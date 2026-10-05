<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\PortfolioContent;
use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * The portfolio's content: homepage text and SEO, the experience timeline
 * and the projects.
 *
 * Safe to run on a site that already has content: a record is only created
 * when it is missing (experiences are matched on role + company, projects on
 * slug), so nothing edited or deleted in the admin is overwritten or brought
 * back. Run it on a fresh install with `php artisan db:seed`.
 */
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        PortfolioContent::query()->firstOrCreate([], $this->content());

        foreach ($this->experiences() as $i => $item) {
            Experience::query()->firstOrCreate(
                ['role' => $item['role'], 'company' => $item['company']],
                $item + ['sort_order' => $i + 1, 'is_active' => true],
            );
        }

        foreach ($this->projects() as $i => $item) {
            Project::query()->firstOrCreate(
                ['slug' => $item['slug']],
                $item + ['sort_order' => $i + 1, 'is_active' => true],
            );
        }
    }

    /** Homepage hero, about, contact details and SEO. */
    public function content(): array
    {
        return [
            'hero_greeting' => "Hi I'm",
            'hero_name' => 'Delwar Hossain',
            'hero_roles' => 'Full Stack Developer, Laravel Developer, Vue.js Developer',
            'hero_description' => 'Full Stack Developer specialising in PHP, Laravel and Vue.js. I build and optimise enterprise web applications and REST APIs, with a focus on clean, scalable and secure code.',
            'about_title' => 'About me',
            // A blank line starts a new paragraph on the site.
            'about_description' => implode("\n\n", [
                "I'm a Full Stack Developer working mainly with PHP, Laravel and Vue.js. I enjoy turning complex business processes into clean, maintainable web applications and well-designed REST APIs.",
                'I hold a Bachelor of Science in Computer Science & Engineering from Bangladesh Army International University of Science and Technology (BAIUST), graduating in 2020 with 161 credits.',
                'I currently work as a Software Engineer at ACI Limited in Dhaka. Before that I built enterprise solutions at MBM Group and Ringer Soft Limited. My specialisation is the Laravel framework and Vue.js.',
            ]),
            'contact_email' => 'delwarhossain1103104@gmail.com',
            'contact_phone' => '+8801797384242',
            'contact_location' => 'Mirpur-12, Dhaka, Bangladesh',
            'linkedin_url' => 'https://www.linkedin.com/in/delwarhossaindev/',
            'github_url' => 'https://github.com/delwarhossaindev',
            'meta_title' => 'Delwar Hossain — Full Stack Developer (Laravel & Vue.js)',
            'meta_description' => 'Portfolio of Delwar Hossain, a Full Stack Developer in Dhaka building enterprise web applications, ERP systems and REST APIs with Laravel, Vue.js and MySQL.',
            'meta_keywords' => 'Delwar Hossain, Full Stack Developer, Laravel Developer, Vue.js Developer, PHP Developer, Dhaka, Bangladesh',
            'site_url' => 'https://delwarhossain.xyz',
        ];
    }

    /**
     * Timeline, newest first. Ranges are "Month YYYY - Month YYYY|Present";
     * the site adds the duration itself, so don't write "(1.7 yrs)" here.
     */
    public function experiences(): array
    {
        return [
            [
                'role' => 'Software Engineer',
                'company' => 'ACI Limited',
                'location' => 'ACI Centre 245, Tejgaon Industrial Area, Dhaka-1208',
                'date_range' => 'March 2024 - Present',
                'description' => 'Writing clean and efficient code in PHP (Laravel). Troubleshooting, testing, and maintaining applications and databases. Building effective REST APIs with extendable, manageable, and secured code.',
                'technologies' => 'Laravel, Vue.js, REST API, MySQL',
                'icon' => 'fas fa-briefcase',
            ],
            [
                'role' => 'Software Engineer',
                'company' => 'MBM Group',
                'location' => 'Mirpur DOHS, Dhaka',
                'date_range' => 'June 2022 - February 2024',
                'description' => 'Worked on Merchandising, Commercial, Store, Industrial Engineering (IE), and Purchase modules. Ensured extendable, manageable, and secured code.',
                'technologies' => 'Laravel, Vue.js, MySQL, Oracle, GitHub, Trello',
                'icon' => 'fas fa-briefcase',
            ],
            [
                'role' => 'Software Engineer',
                'company' => 'Ringer Soft Limited',
                'location' => 'Chittagong',
                'date_range' => 'October 2020 - May 2022',
                'description' => 'Took ownership of back-end and front-end on multiple projects including HR & Payroll, Inventory, POS, and School Management System.',
                'technologies' => 'Laravel, JavaScript, jQuery, MySQL, SSLCOMMERZ',
                'icon' => 'fas fa-code',
            ],
            [
                'role' => 'Jr. Software Engineer',
                'company' => 'ICT Wing (BAIUST)',
                'location' => 'Cumilla Cantonment',
                'date_range' => 'January 2020 - September 2020',
                'description' => 'Worked on Online Exam Registration System and Online Based Android Application.',
                'technologies' => 'PHP, Laravel, JavaScript, jQuery, MySQL, Java',
                'icon' => 'fas fa-laptop-code',
            ],
            [
                'role' => 'BSc in Computer Science & Engineering',
                'company' => 'Bangladesh Army International University of Science and Technology (BAIUST)',
                'location' => 'Cumilla Cantonment',
                'date_range' => 'Graduated 2020 | 4 Years | 161 Credits',
                'description' => 'Completed Bachelor of Science degree in Computer Science & Engineering with a strong foundation in software development, algorithms, data structures, and engineering principles.',
                'technologies' => null,
                'icon' => 'fas fa-graduation-cap',
            ],
        ];
    }

    /** Projects, in display order. Role, client and duration come from the matching job. */
    public function projects(): array
    {
        return [
            [
                'title' => 'Enterprise Web Application',
                'slug' => 'enterprise-web-application',
                'description' => 'Full-scale enterprise application at ACI Limited. Writing clean and efficient code, troubleshooting and maintaining applications and databases. Building effective REST APIs with extendable, manageable, and secured architecture.',
                'long_description' => "An enterprise web application developed and maintained at ACI Limited.\n\nMy work covers the full stack: building features in Laravel and Vue.js, designing REST APIs for other systems to consume, and troubleshooting, testing and maintaining the application and its MySQL databases in production.",
                'key_features' => [
                    'REST APIs built to be extendable, manageable and secure',
                    'Laravel back end with a Vue.js front end',
                    'MySQL database design, maintenance and optimisation',
                    'Ongoing troubleshooting, testing and production support',
                ],
                'company_badge' => 'ACI Limited',
                'client' => 'ACI Limited',
                'role' => 'Software Engineer',
                'duration' => 'March 2024 - Present',
                'icon' => 'fas fa-building',
                'technologies' => 'Laravel, Vue.js, REST API, MySQL',
                'is_featured' => true,
            ],
            [
                'title' => 'ERP System - Merchandising, Commercial, Store, IE & Purchase',
                'slug' => 'erp-system-merchandising-commercial-store-ie-purchase',
                'description' => 'Comprehensive ERP solution covering Merchandising, Commercial, Store, Industrial Engineering (IE), and Purchase modules.',
                'long_description' => "An ERP system for MBM Group covering the core operations of a manufacturing business.\n\nI worked across several modules of the system, keeping the code extendable, manageable and secure as new requirements were added.",
                'key_features' => [
                    'Merchandising module',
                    'Commercial module',
                    'Store (inventory) module',
                    'Industrial Engineering (IE) module',
                    'Purchase module',
                ],
                'company_badge' => 'MBM Group',
                'client' => 'MBM Group',
                'role' => 'Software Engineer',
                'duration' => 'June 2022 - February 2024',
                'icon' => 'fas fa-industry',
                'technologies' => 'Laravel, Vue.js, MySQL, Oracle, Trello',
                'is_featured' => true,
            ],
            [
                'title' => 'HR & Payroll, Inventory, POS System',
                'slug' => 'hr-payroll-inventory-pos-system',
                'description' => 'Multiple enterprise solutions including HR & Payroll management, Inventory tracking, and Point of Sale system.',
                'long_description' => "A set of business applications built at Ringer Soft Limited.\n\nI took ownership of both the back end and the front end, delivering HR & Payroll, Inventory and Point of Sale solutions, including online payment integration with SSLCOMMERZ.",
                'key_features' => [
                    'HR & Payroll management',
                    'Inventory tracking',
                    'Point of Sale (POS)',
                    'Online payments via SSLCOMMERZ',
                ],
                'company_badge' => 'Ringer Soft',
                'client' => 'Ringer Soft Limited',
                'role' => 'Software Engineer',
                'duration' => 'October 2020 - May 2022',
                'icon' => 'fas fa-folder-open',
                'technologies' => 'Laravel, JavaScript, jQuery, MySQL, SSLCOMMERZ',
                'is_featured' => false,
            ],
            [
                'title' => 'School Management System',
                'slug' => 'school-management-system',
                'description' => 'Complete school management solution with student enrollment, attendance tracking, grade management, and administrative tools.',
                'long_description' => "A school management system built at Ringer Soft Limited to run a school's day-to-day administration from one place.",
                'key_features' => [
                    'Student enrollment',
                    'Attendance tracking',
                    'Grade management',
                    'Administrative tools',
                ],
                'company_badge' => 'Ringer Soft',
                'client' => 'Ringer Soft Limited',
                'role' => 'Software Engineer',
                'duration' => 'October 2020 - May 2022',
                'icon' => 'fas fa-school',
                'technologies' => 'Laravel, JavaScript, jQuery, MySQL',
                'is_featured' => false,
            ],
            [
                'title' => 'Online Exam Registration System',
                'slug' => 'online-exam-registration-system',
                'description' => "Online Exam Registration System handling Admission, Semester & Referred Exam registrations. Designed for Cumilla Cantonment's ICT Wing.",
                'long_description' => "An online registration system for the ICT Wing at Cumilla Cantonment (BAIUST), replacing paper-based exam registration.",
                'key_features' => [
                    'Admission exam registration',
                    'Semester exam registration',
                    'Referred exam registration',
                ],
                'company_badge' => 'BAIUST',
                'client' => 'ICT Wing (BAIUST)',
                'role' => 'Jr. Software Engineer',
                'duration' => 'January 2020 - September 2020',
                'icon' => 'fas fa-laptop-code',
                'technologies' => 'PHP, Laravel, JavaScript, jQuery, MySQL',
                'is_featured' => false,
            ],
            [
                'title' => 'Online Based Android Application',
                'slug' => 'online-based-android-application',
                'description' => 'Android-based mobile application developed for BAIUST ICT Wing. Built with Java and integrated with web backend.',
                'long_description' => 'An Android application for the BAIUST ICT Wing, written in Java and connected to a PHP and MySQL web back end.',
                'key_features' => [
                    'Native Android app written in Java',
                    'Integrated with a PHP / MySQL web back end',
                ],
                'company_badge' => 'BAIUST',
                'client' => 'ICT Wing (BAIUST)',
                'role' => 'Jr. Software Engineer',
                'duration' => 'January 2020 - September 2020',
                'icon' => 'fas fa-mobile-alt',
                'technologies' => 'Java, PHP, MySQL, Android',
                'is_featured' => false,
            ],
        ];
    }
}
