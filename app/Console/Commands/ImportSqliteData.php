<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Copies every row from an old SQLite database into the current default
 * connection (MySQL). Run `php artisan migrate --force` first so the target
 * tables exist; target tables are emptied before the copy.
 */
class ImportSqliteData extends Command
{
    protected $signature = 'db:import-sqlite
        {path=database/database.sqlite : Path to the SQLite file}
        {--force : Skip the confirmation prompt}';

    protected $description = 'Copy all data from a SQLite database into the default (MySQL) connection';

    // Transient or framework-managed tables that should not be copied.
    private const SKIP = ['migrations', 'sqlite_sequence', 'cache', 'cache_locks', 'sessions'];

    public function handle(): int
    {
        $path = base_path($this->argument('path'));
        if (! is_file($path)) {
            $path = $this->argument('path');
        }
        if (! is_file($path)) {
            $this->error("SQLite file not found: {$this->argument('path')}");

            return self::FAILURE;
        }

        $target = DB::connection();
        if ($target->getDriverName() === 'sqlite') {
            $this->error('The default connection is still SQLite. Set DB_CONNECTION=mysql in .env first.');

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm("Existing rows in '{$target->getDatabaseName()}' will be replaced. Continue?")) {
            return self::FAILURE;
        }

        Config::set('database.connections.sqlite_import', [
            'driver' => 'sqlite',
            'database' => $path,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        $source = DB::connection('sqlite_import');

        $tables = collect($source->select("SELECT name FROM sqlite_master WHERE type = 'table'"))
            ->pluck('name')
            ->reject(fn ($t) => in_array($t, self::SKIP, true));

        Schema::disableForeignKeyConstraints();

        try {
            foreach ($tables as $table) {
                if (! Schema::hasTable($table)) {
                    $this->warn("Skipped {$table}: not in target database");

                    continue;
                }

                $columns = array_values(array_intersect(
                    Schema::connection('sqlite_import')->getColumnListing($table),
                    Schema::getColumnListing($table)
                ));

                $target->table($table)->truncate();

                $count = 0;
                $source->table($table)->select($columns)->orderBy($columns[0])
                    ->chunk(200, function ($rows) use ($target, $table, &$count) {
                        $target->table($table)->insert($rows->map(fn ($r) => (array) $r)->all());
                        $count += $rows->count();
                    });

                $this->line(sprintf('  %-28s %d rows', $table, $count));
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        Artisan::call('optimize:clear');
        $this->info('Import complete.');

        return self::SUCCESS;
    }
}
