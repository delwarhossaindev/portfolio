<?php

namespace App\Http\Controllers;

use App\Mail\ContactSubmitted;
use App\Models\Contact;
use App\Models\PortfolioContent;
use App\Models\Experience;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;

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

    public function showProject(Project $project)
    {
        if (! $project->is_active) {
            abort(404);
        }

        $project->increment('view_count');

        $relatedProjects = Project::where('is_active', true)
            ->where('id', '!=', $project->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('project-detail', [
            'project' => $project,
            'related' => $relatedProjects,
            'content' => $this->getPortfolioContent(),
        ]);
    }

    public function contact(Request $request)
    {
        // Honeypot - if "website" field is filled, treat as bot
        if (filled($request->input('website'))) {
            return back()->with('success', 'Message sent successfully!');
        }

        // Rate limit: 3 submissions per hour per IP
        $rateKey = 'contact:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, 3)) {
            $minutes = ceil(RateLimiter::availableIn($rateKey) / 60);
            return back()
                ->withInput()
                ->withErrors(['message' => "Too many messages sent. Please try again in {$minutes} minutes."]);
        }

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|min:3|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        RateLimiter::hit($rateKey, 3600);

        $contact = Contact::create($validated + [
            'ip_address' => $request->ip(),
        ]);

        $this->sendContactNotification($contact);

        return back()->with('success', 'Message sent successfully! I will get back to you soon.');
    }

    private function sendContactNotification(Contact $contact): void
    {
        try {
            $recipient = $this->getPortfolioContent()->contact_email;
            if ($recipient) {
                Mail::to($recipient)->send(new ContactSubmitted($contact));
            }
        } catch (\Throwable $e) {
            Log::error('Contact notification email failed', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function terminalPanel()
    {
        abort_unless(app()->environment('local') && config('app.debug'), 404);
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
        // Hard-fail outside local+debug regardless of how the route was reached.
        abort_unless(app()->environment('local') && config('app.debug'), 404);

        $validated = $request->validate([
            'command' => 'required|string|max:500',
        ]);

        $command = trim($validated['command']);

        // Strip optional `php ` prefix
        $command = preg_replace('/^php\s+/i', '', $command);

        // Only allow artisan commands
        if (! preg_match('/^artisan\s+([a-z][a-z0-9:-]*)\b(.*)$/i', $command, $m)) {
            return back()->with([
                'command' => $validated['command'],
                'output' => '',
                'error_output' => 'Only "artisan <command> [args]" is allowed.',
                'exit_code' => 1,
                'successful' => false,
            ]);
        }

        $artisanCmd = strtolower($m[1]);
        $artisanArgs = $m[2];

        // Block destructive/sensitive commands
        $blocked = [
            'env', 'tinker',
            'db:wipe', 'db:seed',
            'migrate:fresh', 'migrate:reset', 'migrate:rollback',
            'storage:unlink',
            'config:cache', 'config:show',
            'app:env',
        ];
        if (in_array($artisanCmd, $blocked, true)
            || str_starts_with($artisanCmd, 'queue:')
            || str_contains($artisanArgs, '--env=')
            || str_contains($artisanArgs, '`')
            || str_contains($artisanArgs, '$(')
            || str_contains($artisanArgs, '|')
            || str_contains($artisanArgs, ';')
            || str_contains($artisanArgs, '&')
            || str_contains($artisanArgs, '>')
            || str_contains($artisanArgs, '<')
        ) {
            return back()->with([
                'command' => $validated['command'],
                'output' => '',
                'error_output' => "Command '{$artisanCmd}' or its arguments are not permitted.",
                'exit_code' => 1,
                'successful' => false,
            ]);
        }

        // Run via Artisan facade (no shell exec) - safer than Process
        try {
            \Artisan::call($artisanCmd, $this->parseArtisanArgs($artisanArgs));
            $output = \Artisan::output();
            return back()->with([
                'command' => $validated['command'],
                'output' => $output,
                'error_output' => '',
                'exit_code' => 0,
                'successful' => true,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Terminal command failed', [
                'command' => $artisanCmd,
                'user' => auth()->user()?->email,
                'error' => $e->getMessage(),
            ]);
            return back()->with([
                'command' => $validated['command'],
                'output' => '',
                'error_output' => $e->getMessage(),
                'exit_code' => 1,
                'successful' => false,
            ]);
        }
    }

    private function parseArtisanArgs(string $argString): array
    {
        $argString = trim($argString);
        if ($argString === '') return [];

        $parts = preg_split('/\s+/', $argString) ?: [];
        $args = [];
        $positional = 1;

        foreach ($parts as $part) {
            if (str_starts_with($part, '--')) {
                $kv = explode('=', substr($part, 2), 2);
                $args['--' . $kv[0]] = $kv[1] ?? true;
            } elseif (str_starts_with($part, '-')) {
                $args[$part] = true;
            } else {
                $args['arg' . ($positional++)] = $part;
            }
        }
        return $args;
    }

    public function dashboard()
    {
        $content = $this->getPortfolioContent();

        return view('admin.dashboard', [
            'stats' => [
                'contacts' => Contact::count(),
                'unreadContacts' => Contact::unread()->count(),
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
            'profile_image' => [
                'nullable', 'file', 'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
                'dimensions:min_width=200,min_height=200,max_width=4000,max_height=4000',
            ],
            'remove_profile_image' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'twitter_handle' => ['nullable', 'string', 'max:50', 'regex:/^@?[A-Za-z0-9_]{1,30}$/'],
            'site_url' => 'nullable|url|max:255',
            'og_image' => [
                'nullable', 'file', 'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
                'dimensions:min_width=600,min_height=315,max_width=4000,max_height=4000',
            ],
            'remove_og_image' => 'nullable|boolean',
        ]);

        $content = PortfolioContent::query()->firstOrNew([]);

        if ($request->boolean('remove_profile_image') && $content->profile_image) {
            Storage::disk('public')->delete($content->profile_image);
            $content->profile_image = null;
        }

        if ($request->hasFile('profile_image')) {
            if ($content->profile_image) {
                Storage::disk('public')->delete($content->profile_image);
            }
            $content->profile_image = $this->storeOptimizedImage($request->file('profile_image'), 'portfolio', 800);
        }

        if ($request->boolean('remove_og_image') && $content->og_image) {
            Storage::disk('public')->delete($content->og_image);
            $content->og_image = null;
        }

        if ($request->hasFile('og_image')) {
            if ($content->og_image) {
                Storage::disk('public')->delete($content->og_image);
            }
            // OG images: 1200x630 ideal, allow up to 1200 wide
            $content->og_image = $this->storeOptimizedImage($request->file('og_image'), 'portfolio/og', 1200, 88);
        }

        $content->fill(collect($validated)
            ->except(['profile_image', 'remove_profile_image', 'og_image', 'remove_og_image'])
            ->toArray());
        $content->save();

        self::clearPortfolioCache();

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

    public static function clearPortfolioCache(): void
    {
        // Kept for backwards compat - cache currently disabled but observers still call this
        Cache::forget('portfolio.content');
        Cache::forget('portfolio.experiences');
        Cache::forget('portfolio.projects');
    }

    /**
     * Resize and re-encode an uploaded image, then store it.
     * Returns the storage-relative path.
     */
    private function storeOptimizedImage($file, string $folder, int $maxDim = 800, int $quality = 85): string
    {
        if (! function_exists('imagecreatefromstring')) {
            return $file->store($folder, 'public');
        }

        try {
            $contents = file_get_contents($file->getRealPath());
            $img = @imagecreatefromstring($contents);
            if (! $img) {
                return $file->store($folder, 'public');
            }

            $srcW = imagesx($img);
            $srcH = imagesy($img);

            // Only resize if larger than max dimension
            if ($srcW > $maxDim || $srcH > $maxDim) {
                if ($srcW > $srcH) {
                    $dstW = $maxDim;
                    $dstH = (int) round($srcH * ($maxDim / $srcW));
                } else {
                    $dstH = $maxDim;
                    $dstW = (int) round($srcW * ($maxDim / $srcH));
                }
                $dst = imagecreatetruecolor($dstW, $dstH);
                imagecopyresampled($dst, $img, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);
                imagedestroy($img);
                $img = $dst;
            }

            $filename = $folder . '/' . uniqid('img_', true) . '.jpg';
            $tmpPath = tempnam(sys_get_temp_dir(), 'opt_');
            imagejpeg($img, $tmpPath, $quality);
            imagedestroy($img);

            Storage::disk('public')->put($filename, file_get_contents($tmpPath));
            @unlink($tmpPath);

            return $filename;
        } catch (\Throwable $e) {
            Log::warning('Image optimization failed, storing original', ['error' => $e->getMessage()]);
            return $file->store($folder, 'public');
        }
    }
}
