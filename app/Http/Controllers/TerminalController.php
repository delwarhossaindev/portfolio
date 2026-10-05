<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/**
 * Browser terminal for whitelisted artisan commands.
 * DEVELOPMENT ONLY: the routes exist only when APP_ENV=local and APP_DEBUG=true,
 * and every action re-checks that in case it is reached some other way.
 */
class TerminalController extends Controller
{
    /** Commands that are destructive, leak secrets, or block the request. */
    private const BLOCKED = [
        'env', 'tinker',
        'db:wipe', 'db:seed',
        'migrate:fresh', 'migrate:reset', 'migrate:rollback',
        'storage:unlink',
        'config:cache', 'config:show',
        'app:env',
    ];

    public function show()
    {
        $this->ensureLocal();

        return view('terminal-panel');
    }

    public function run(Request $request)
    {
        $this->ensureLocal();

        $input = $request->validate(['command' => 'required|string|max:500'])['command'];

        // Accept "artisan x" or "php artisan x".
        $command = preg_replace('/^php\s+/i', '', trim($input));

        if (! preg_match('/^artisan\s+([a-z][a-z0-9:-]*)\b(.*)$/i', $command, $m)) {
            return $this->result($input, error: 'Only "artisan <command> [args]" is allowed.');
        }

        [$name, $args] = [strtolower($m[1]), $m[2]];

        if (! $this->isAllowed($name, $args)) {
            return $this->result($input, error: "Command '{$name}' or its arguments are not permitted.");
        }

        try {
            // Artisan facade, never a shell: arguments can't be interpreted by a shell.
            Artisan::call($name, $this->parseArgs($args));

            return $this->result($input, output: Artisan::output());
        } catch (\Throwable $e) {
            Log::warning('Terminal command failed', [
                'command' => $name,
                'user' => auth()->user()?->email,
                'error' => $e->getMessage(),
            ]);

            return $this->result($input, error: $e->getMessage());
        }
    }

    private function ensureLocal(): void
    {
        abort_unless(app()->environment('local') && config('app.debug'), 404);
    }

    private function isAllowed(string $name, string $args): bool
    {
        if (in_array($name, self::BLOCKED, true) || str_starts_with($name, 'queue:')) {
            return false;
        }

        foreach (['--env=', '`', '$(', '|', ';', '&', '>', '<'] as $needle) {
            if (str_contains($args, $needle)) {
                return false;
            }
        }

        return true;
    }

    /** "foo --bar=1 -v" → ['arg1' => 'foo', '--bar' => '1', '-v' => true] */
    private function parseArgs(string $argString): array
    {
        $args = [];
        $positional = 1;

        foreach (preg_split('/\s+/', trim($argString), -1, PREG_SPLIT_NO_EMPTY) ?: [] as $part) {
            if (str_starts_with($part, '--')) {
                [$key, $value] = array_pad(explode('=', substr($part, 2), 2), 2, true);
                $args['--' . $key] = $value;
            } elseif (str_starts_with($part, '-')) {
                $args[$part] = true;
            } else {
                $args['arg' . ($positional++)] = $part;
            }
        }

        return $args;
    }

    private function result(string $command, string $output = '', string $error = '')
    {
        return back()->with([
            'command' => $command,
            'output' => $output,
            'error_output' => $error,
            'exit_code' => $error === '' ? 0 : 1,
            'successful' => $error === '',
        ]);
    }
}
