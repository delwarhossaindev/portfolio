<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\PortfolioContent;
use App\Models\Project;

/**
 * Public pages: the one-page portfolio and the project detail pages.
 */
class PortfolioController extends Controller
{
    public function index()
    {
        $experiences = Experience::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('portfolio', [
            'content' => PortfolioContent::current(),
            'experiences' => $experiences,
            'career' => Experience::careerStats($experiences),
            'projects' => Project::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function showProject(Project $project)
    {
        abort_unless($project->is_active, 404);

        // Count views without touching updated_at (it's shown as "last updated").
        // toBase(): the Eloquent builder would also bump updated_at.
        Project::whereKey($project->id)->toBase()->increment('view_count');
        $project->view_count++;

        return view('project-detail', [
            'project' => $project,
            'related' => Project::where('is_active', true)
                ->whereKeyNot($project->id)
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
            'content' => PortfolioContent::current(),
        ]);
    }
}
