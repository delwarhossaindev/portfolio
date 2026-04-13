<?php

namespace App\Http\Controllers;

use App\Models\PortfolioContent;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('portfolio', [
            'content' => $this->getPortfolioContent(),
        ]);
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Store contact message
        \App\Models\Contact::create($request->only(['name', 'email', 'subject', 'message']));

        return back()->with('success', 'Message sent successfully!');
    }

    public function terminalPanel()
    {
        return view('terminal-panel');
    }

    public function runTerminalCommand(Request $request)
    {
        $validated = $request->validate([
            'command' => 'required|string|max:1000',
        ]);

        $command = trim($validated['command']);
        if (preg_match('/^php\s+artisan\b/i', $command) === 1) {
            $command = preg_replace('/^php\b/i', '"' . PHP_BINARY . '"', $command, 1);
        } elseif (preg_match('/^artisan\b/i', $command) === 1) {
            $command = '"' . PHP_BINARY . '" ' . $command;
        }

        $result = Process::path(base_path())
            ->timeout(30)
            ->run($command);

        return back()->with([
            'command' => $validated['command'],
            'output' => $result->output(),
            'error_output' => $result->errorOutput(),
            'exit_code' => $result->exitCode(),
            'successful' => $result->successful(),
        ]);
    }

    public function adminDashboard()
    {
        $content = $this->getPortfolioContent();

        return view('admin.dashboard', [
            'content' => $content,
            'stats' => [
                'contacts' => Contact::query()->count(),
                'contentUpdatedAt' => optional($content->updated_at)?->diffForHumans() ?? 'N/A',
                'lastLoginEmail' => auth()->user()?->email ?? 'N/A',
            ],
        ]);
    }

    public function updateAdminDashboard(Request $request)
    {
        $validated = $request->validate([
            'hero_greeting' => 'required|string|max:255',
            'hero_name' => 'required|string|max:255',
            'hero_roles' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:255',
            'contact_location' => 'required|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
        ]);

        $content = PortfolioContent::query()->first();

        if (! $content) {
            PortfolioContent::query()->create($validated);
        } else {
            $content->update($validated);
        }

        return back()->with('admin_success', 'Portfolio content updated successfully.');
    }

    private function getPortfolioContent(): PortfolioContent
    {
        return PortfolioContent::query()->firstOrCreate([], [
            'hero_greeting' => "Hi I'm",
            'hero_name' => 'Delwar Hossain',
            'hero_roles' => 'Full Stack Developer',
            'hero_description' => 'Full Stack Developer with over 5 years of experience in PHP, Laravel, and Vue JS. I have demonstrated expertise in developing and optimizing web applications. I am passionate about writing clean and scalable code.',
            'about_title' => 'About me',
            'about_description' => 'I am a Full Stack Developer with over 5 years of experience in PHP, Laravel, and Vue JS. I hold a Bachelor of Science in Computer Science & Engineering from BAIUST. Currently working as a Software Engineer at ACI Limited in Dhaka.',
            'contact_email' => 'delwarhossain1103104@gmail.com',
            'contact_phone' => '+8801797384242',
            'contact_location' => 'Mirpur-12, Dhaka, Bangladesh',
            'linkedin_url' => 'https://www.linkedin.com/in/delwarhossaindev/',
            'github_url' => 'https://github.com/delwarhossaindev',
        ]);
    }
}
