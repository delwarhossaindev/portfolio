<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PortfolioContent;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->orderByDesc('published_at');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        if ($tag = trim((string) $request->input('tag'))) {
            $query->where('tags', 'like', "%{$tag}%");
        }

        $articles = $query->paginate(9)->withQueryString();

        $allTags = Article::published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatMap(fn ($t) => array_map('trim', explode(',', $t)))
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        return view('blog.index', [
            'articles' => $articles,
            'allTags' => $allTags,
            'currentTag' => $tag ?: null,
            'search' => $search ?: null,
            'content' => PortfolioContent::query()->firstOrCreate([]),
        ]);
    }

    public function show(Article $article)
    {
        if (! $article->is_published) {
            if (! auth()->check()) {
                abort(404);
            }
        }

        $article->increment('view_count');

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', [
            'article' => $article,
            'related' => $related,
            'content' => PortfolioContent::query()->firstOrCreate([]),
        ]);
    }
}
