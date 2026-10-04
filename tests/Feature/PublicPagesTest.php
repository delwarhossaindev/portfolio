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

    public function test_sitemap_is_served(): void
    {
        $this->get('/sitemap.xml')->assertOk();
    }
}
