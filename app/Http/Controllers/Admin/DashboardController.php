<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Experience;
use App\Models\PortfolioContent;
use App\Models\Project;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $content = PortfolioContent::current();

        return view('admin.dashboard', [
            'stats' => [
                'contacts' => Contact::count(),
                'unreadContacts' => Contact::unread()->count(),
                'experiences' => Experience::count(),
                'activeExperiences' => Experience::where('is_active', true)->count(),
                'projects' => Project::count(),
                'activeProjects' => Project::where('is_active', true)->count(),
                'featuredProjects' => Project::where('is_featured', true)->count(),
                'articles' => Article::count(),
                'publishedArticles' => Article::published()->count(),
                'contentUpdatedAt' => $content->updated_at?->diffForHumans() ?? 'N/A',
                'lastLoginEmail' => auth()->user()?->email ?? 'N/A',
            ],
            'recentContacts' => Contact::orderByDesc('id')->limit(5)->get(),
        ]);
    }
}
