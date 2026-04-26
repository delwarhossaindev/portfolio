<?php

namespace App\Http\Controllers;

use App\Models\Project;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            [
                'loc' => url('/'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
        ];

        Project::where('is_active', true)
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at'])
            ->each(function ($project) use (&$urls) {
                $urls[] = [
                    'loc' => route('projects.show', $project->slug),
                    'lastmod' => $project->updated_at?->toIso8601String() ?? now()->toIso8601String(),
                    'changefreq' => 'monthly',
                    'priority' => '0.8',
                ];
            });

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
