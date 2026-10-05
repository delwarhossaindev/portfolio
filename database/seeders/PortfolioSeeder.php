<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\PortfolioContent;
use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Starter content for a fresh install. Each table is only filled while it is
 * empty, so running the seeder again never duplicates or restores entries
 * that were deliberately deleted in the admin.
 */
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        PortfolioContent::current();

        if (Experience::count() === 0) {
            foreach ($this->experiences() as $i => $item) {
                Experience::create($item + ['sort_order' => $i + 1, 'is_active' => true]);
            }
        }

        if (Project::count() === 0) {
            foreach ($this->projects() as $i => $item) {
                Project::create($item + ['sort_order' => $i + 1, 'is_active' => true]);
            }
        }
    }

    private function experiences(): array
    {
        return [
            [
                'role' => 'Software Engineer',
                'company' => 'ACI Limited',
                'location' => 'ACI Centre 245, Tejgaon Industrial Area, Dhaka-1208',
                'date_range' => 'March 2024 - Present',
                'description' => 'Writing clean and efficient code in PHP (Laravel). Troubleshooting, testing, and maintaining applications and databases. Building effective REST APIs with extendable, manageable, and secured code.',
                'technologies' => 'Laravel, Vue.js, REST API',
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
                'location' => null,
                'date_range' => 'Graduated 2020 | 4 Years | 161 Credits',
                'description' => 'Completed Bachelor of Science degree in Computer Science & Engineering with a strong foundation in software development, algorithms, data structures, and engineering principles.',
                'technologies' => null,
                'icon' => 'fas fa-graduation-cap',
            ],
        ];
    }

    private function projects(): array
    {
        return [
            [
                'title' => 'Enterprise Web Application',
                'description' => 'Full-scale enterprise application at ACI Limited. Writing clean and efficient code, troubleshooting and maintaining applications and databases. Building effective REST APIs with extendable, manageable, and secured architecture.',
                'company_badge' => 'ACI Limited',
                'icon' => 'fas fa-building',
                'technologies' => 'Laravel, Vue.js, REST API, MySQL',
                'is_featured' => true,
            ],
            [
                'title' => 'ERP System - Merchandising, Commercial, Store, IE & Purchase',
                'description' => 'Comprehensive ERP solution covering Merchandising, Commercial, Store, Industrial Engineering (IE), and Purchase modules.',
                'company_badge' => 'MBM Group',
                'icon' => 'fas fa-industry',
                'technologies' => 'Laravel, Vue.js, MySQL, Oracle, Trello',
                'is_featured' => true,
            ],
            [
                'title' => 'HR & Payroll, Inventory, POS System',
                'description' => 'Multiple enterprise solutions including HR & Payroll management, Inventory tracking, and Point of Sale system.',
                'company_badge' => 'Ringer Soft',
                'icon' => 'fas fa-folder-open',
                'technologies' => 'Laravel, JavaScript, jQuery, MySQL, SSLCOMMERZ',
                'is_featured' => false,
            ],
            [
                'title' => 'School Management System',
                'description' => 'Complete school management solution with student enrollment, attendance tracking, grade management, and administrative tools.',
                'company_badge' => 'Ringer Soft',
                'icon' => 'fas fa-school',
                'technologies' => 'Laravel, JavaScript, jQuery, MySQL',
                'is_featured' => false,
            ],
            [
                'title' => 'Online Exam Registration System',
                'description' => "Online Exam Registration System handling Admission, Semester & Referred Exam registrations. Designed for Cumilla Cantonment's ICT Wing.",
                'company_badge' => 'BAIUST',
                'icon' => 'fas fa-laptop-code',
                'technologies' => 'PHP, Laravel, JavaScript, jQuery, MySQL',
                'is_featured' => false,
            ],
            [
                'title' => 'Online Based Android Application',
                'description' => 'Android-based mobile application developed for BAIUST ICT Wing. Built with Java and integrated with web backend.',
                'company_badge' => 'BAIUST',
                'icon' => 'fas fa-mobile-alt',
                'technologies' => 'Java, PHP, MySQL, Android',
                'is_featured' => false,
            ],
        ];
    }
}
