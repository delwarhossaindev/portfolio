<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Delwar Hossain')
            ->assertSee('footer-signin', false);
    }

    public function test_project_detail_page_renders_by_slug(): void
    {
        $project = Project::create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'is_active' => true,
        ]);

        $this->get('/projects/' . $project->slug)->assertOk()->assertSee('Test Project');
    }

    public function test_homepage_does_not_recreate_content_the_admin_deleted(): void
    {
        $this->seed(\Database\Seeders\PortfolioSeeder::class);
        \App\Models\Experience::query()->delete();

        $this->get('/')->assertOk();

        $this->assertSame(0, \App\Models\Experience::count());
    }

    public function test_viewing_a_project_counts_the_view_without_touching_updated_at(): void
    {
        $project = Project::create(['title' => 'Counted', 'is_active' => true]);
        $updatedAt = $project->updated_at;
        $this->travel(1)->hours();

        $this->get('/projects/' . $project->slug)->assertOk()->assertSee('1');

        $project->refresh();
        $this->assertSame(1, $project->view_count);
        $this->assertTrue($project->updated_at->equalTo($updatedAt));
    }

    public function test_inactive_project_returns_404(): void
    {
        $project = Project::create(['title' => 'Hidden', 'is_active' => false]);

        $this->get('/projects/' . $project->slug)->assertNotFound();
    }

    public function test_sitemap_is_served(): void
    {
        $this->get('/sitemap.xml')->assertOk();
    }
}
