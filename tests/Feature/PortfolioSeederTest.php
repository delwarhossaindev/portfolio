<?php

namespace Tests\Feature;

use App\Models\Experience;
use App\Models\PortfolioContent;
use App\Models\Project;
use Database\Seeders\PortfolioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_fresh_install_gets_complete_content(): void
    {
        $this->seed(PortfolioSeeder::class);

        $this->assertSame(5, Experience::count());
        $this->assertSame(6, Project::count());

        $content = PortfolioContent::first();
        $this->assertNotNull($content->meta_title);
        $this->assertStringContainsString("\n\n", $content->about_description);

        $project = Project::where('slug', 'erp-system-merchandising-commercial-store-ie-purchase')->first();
        $this->assertSame('MBM Group', $project->client);
        $this->assertNotEmpty($project->key_features);

        // No hand-written durations: the site computes them.
        $this->assertFalse(Experience::where('date_range', 'like', '%yrs)%')->exists());
    }

    public function test_running_twice_creates_no_duplicates(): void
    {
        $this->seed(PortfolioSeeder::class);
        $this->seed(PortfolioSeeder::class);

        $this->assertSame(1, PortfolioContent::count());
        $this->assertSame(5, Experience::count());
        $this->assertSame(6, Project::count());
    }

    public function test_never_overwrites_admin_edits(): void
    {
        $this->seed(PortfolioSeeder::class);

        PortfolioContent::first()->update(['hero_description' => 'Edited in admin']);
        Project::where('slug', 'school-management-system')->update(['title' => 'Renamed in admin']);

        $this->seed(PortfolioSeeder::class);

        $this->assertSame('Edited in admin', PortfolioContent::first()->hero_description);
        $this->assertSame('Renamed in admin', Project::where('slug', 'school-management-system')->value('title'));
    }

    public function test_seeded_homepage_renders_with_all_projects(): void
    {
        $this->seed(PortfolioSeeder::class);

        $this->get('/')->assertOk()
            ->assertSee('Online Based Android Application')
            ->assertSee('March 2024 - Present ·', false);

        $this->get('/projects/enterprise-web-application')->assertOk()
            ->assertSee('REST APIs built to be extendable, manageable and secure');
    }
}
