<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PortfolioContent;
use App\Models\Experience;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('portfolio', [
            'content' => $this->getPortfolioContent(),
            'experiences' => $this->getExperiences(),
            'projects' => $this->getProjects(),
        ]);
    }

    private function getExperiences()
    {
        if (Experience::count() === 0) {
            $defaults = [
                [
                    'role' => 'Software Engineer',
                    'company' => 'ACI Limited',
                    'location' => 'ACI Centre 245, Tejgaon Industrial Area, Dhaka-1208',
                    'date_range' => 'March 2024 - Present (1.7 yrs)',
                    'description' => 'Writing clean and efficient code in PHP (Laravel). Troubleshooting, testing, and maintaining applications and databases. Building effective REST APIs with extendable, manageable, and secured code.',
                    'technologies' => 'Laravel, Vue.js, REST API',
                    'icon' => 'fas fa-briefcase',
                    'sort_order' => 1,
                ],
                [
                    'role' => 'Software Engineer',
                    'company' => 'MBM Group',
                    'location' => 'Mirpur DOHS, Dhaka',
                    'date_range' => 'June 2022 - February 2024 (1.7 yrs)',
                    'description' => 'Worked on Merchandising, Commercial, Store, Industrial Engineering (IE), and Purchase modules. Ensured extendable, manageable, and secured code.',
                    'technologies' => 'Laravel, Vue.js, MySQL, Oracle, GitHub, Trello',
                    'icon' => 'fas fa-briefcase',
                    'sort_order' => 2,
                ],
                [
                    'role' => 'Software Engineer',
                    'company' => 'Ringer Soft Limited',
                    'location' => 'Chittagong',
                    'date_range' => 'October 2020 - May 2022 (1.6 yrs)',
                    'description' => 'Took ownership of back-end and front-end on multiple projects including HR & Payroll, Inventory, POS, and School Management System.',
                    'technologies' => 'Laravel, JavaScript, jQuery, MySQL, SSLCOMMERZ',
                    'icon' => 'fas fa-code',
                    'sort_order' => 3,
                ],
                [
                    'role' => 'Jr. Software Engineer',
                    'company' => 'ICT Wing (BAIUST)',
                    'location' => 'Cumilla Cantonment',
                    'date_range' => 'January 2020 - September 2020 (0.7 yr)',
                    'description' => 'Worked on Online Exam Registration System and Online Based Android Application.',
                    'technologies' => 'PHP, Laravel, JavaScript, jQuery, MySQL, Java',
                    'icon' => 'fas fa-laptop-code',
                    'sort_order' => 4,
                ],
                [
                    'role' => 'BSc in Computer Science & Engineering',
                    'company' => 'Bangladesh Army International University of Science and Technology (BAIUST)',
                    'location' => null,
                    'date_range' => 'Graduated 2020 | 4 Years | 161 Credits',
                    'description' => 'Completed Bachelor of Science degree in Computer Science & Engineering with a strong foundation in software development, algorithms, data structures, and engineering principles.',
                    'technologies' => null,
                    'icon' => 'fas fa-graduation-cap',
                    'sort_order' => 5,
                ],
            ];
            foreach ($defaults as $item) {
                Experience::create($item + ['is_active' => true]);
            }
        }

        return Experience::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    private function getProjects()
    {
        if (Project::count() === 0) {
            $defaults = [
                [
                    'title' => 'Enterprise Web Application',
                    'description' => 'Full-scale enterprise application at ACI Limited. Writing clean and efficient code, troubleshooting and maintaining applications and databases. Building effective REST APIs with extendable, manageable, and secured architecture.',
                    'company_badge' => 'ACI Limited',
                    'icon' => 'fas fa-building',
                    'technologies' => 'Laravel, Vue.js, REST API, MySQL',
                    'is_featured' => true,
                    'sort_order' => 1,
                ],
                [
                    'title' => 'ERP System - Merchandising, Commercial, Store, IE & Purchase',
                    'description' => 'Comprehensive ERP solution covering Merchandising, Commercial, Store, Industrial Engineering (IE), and Purchase modules.',
                    'company_badge' => 'MBM Group',
                    'icon' => 'fas fa-industry',
                    'technologies' => 'Laravel, Vue.js, MySQL, Oracle, Trello',
                    'is_featured' => true,
                    'sort_order' => 2,
                ],
                [
                    'title' => 'HR & Payroll, Inventory, POS System',
                    'description' => 'Multiple enterprise solutions including HR & Payroll management, Inventory tracking, and Point of Sale system.',
                    'company_badge' => 'Ringer Soft',
                    'icon' => 'fas fa-folder-open',
                    'technologies' => 'Laravel, JavaScript, jQuery, MySQL, SSLCOMMERZ',
                    'is_featured' => false,
                    'sort_order' => 3,
                ],
                [
                    'title' => 'School Management System',
                    'description' => 'Complete school management solution with student enrollment, attendance tracking, grade management, and administrative tools.',
                    'company_badge' => 'Ringer Soft',
                    'icon' => 'fas fa-school',
                    'technologies' => 'Laravel, JavaScript, jQuery, MySQL',
                    'is_featured' => false,
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Online Exam Registration System',
                    'description' => "Online Exam Registration System handling Admission, Semester & Referred Exam registrations. Designed for Cumilla Cantonment's ICT Wing.",
                    'company_badge' => 'BAIUST',
                    'icon' => 'fas fa-laptop-code',
                    'technologies' => 'PHP, Laravel, JavaScript, jQuery, MySQL',
                    'is_featured' => false,
                    'sort_order' => 5,
                ],
                [
                    'title' => 'Online Based Android Application',
                    'description' => 'Android-based mobile application developed for BAIUST ICT Wing. Built with Java and integrated with web backend.',
                    'company_badge' => 'BAIUST',
                    'icon' => 'fas fa-mobile-alt',
                    'technologies' => 'Java, PHP, MySQL, Android',
                    'is_featured' => false,
                    'sort_order' => 6,
                ],
            ];
            foreach ($defaults as $item) {
                Project::create($item + ['is_active' => true]);
            }
        }

        return Project::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
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

    private function resolvePhpBinary(): string
    {
        $configured = env('TERMINAL_PHP_BINARY');
        if ($configured && is_file($configured)) {
            return $configured;
        }

        $default = PHP_BINARY;
        if ($default && stripos($default, 'httpd') === false && stripos($default, 'apache') === false && is_file($default)) {
            return $default;
        }

        $candidates = [];
        if (stripos(PHP_OS, 'WIN') === 0) {
            foreach (['C:\\wamp64\\bin\\php', 'D:\\wamp64\\bin\\php', 'C:\\wamp\\bin\\php', 'C:\\xampp\\php'] as $dir) {
                if (is_dir($dir)) {
                    foreach (glob($dir . '\\php*\\php.exe') ?: [] as $match) {
                        $candidates[] = $match;
                    }
                    if (is_file($dir . '\\php.exe')) {
                        $candidates[] = $dir . '\\php.exe';
                    }
                }
            }
        } else {
            $candidates = array_filter(['/usr/bin/php', '/usr/local/bin/php'], 'is_file');
        }

        if (! empty($candidates)) {
            $runningVersion = PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;
            $matched = array_values(array_filter($candidates, fn ($p) => str_contains(str_replace('\\', '/', $p), '/php' . $runningVersion)));
            if (! empty($matched)) {
                rsort($matched);
                return $matched[0];
            }
            rsort($candidates);
            return $candidates[0];
        }

        return $default;
    }

    public function runTerminalCommand(Request $request)
    {
        $validated = $request->validate([
            'command' => 'required|string|max:1000',
        ]);

        $command = trim($validated['command']);
        $phpBinary = $this->resolvePhpBinary();
        if (preg_match('/^php\s+artisan\b/i', $command) === 1) {
            $command = preg_replace('/^php\b/i', '"' . $phpBinary . '"', $command, 1);
        } elseif (preg_match('/^artisan\b/i', $command) === 1) {
            $command = '"' . $phpBinary . '" ' . $command;
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

    public function dashboard()
    {
        $content = $this->getPortfolioContent();

        return view('admin.dashboard', [
            'stats' => [
                'contacts' => Contact::count(),
                'experiences' => Experience::count(),
                'projects' => Project::count(),
                'featuredProjects' => Project::where('is_featured', true)->count(),
                'activeExperiences' => Experience::where('is_active', true)->count(),
                'activeProjects' => Project::where('is_active', true)->count(),
                'contentUpdatedAt' => optional($content->updated_at)?->diffForHumans() ?? 'N/A',
                'lastLoginEmail' => auth()->user()?->email ?? 'N/A',
            ],
            'recentContacts' => Contact::orderByDesc('id')->limit(5)->get(),
        ]);
    }

    public function homeEdit()
    {
        return view('admin.home', [
            'content' => $this->getPortfolioContent(),
        ]);
    }

    public function homeUpdate(Request $request)
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
