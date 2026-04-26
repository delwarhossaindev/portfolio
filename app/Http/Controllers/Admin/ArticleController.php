<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        return view('admin.articles.index', [
            'items' => Article::orderByDesc('id')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.articles.form', [
            'item' => new Article(['is_published' => false]),
        ]);
    }

    public function store(Request $request)
    {
        $article = new Article($this->validatedData($request));
        $article->author_id = auth()->id();
        $this->handleCover($request, $article);
        $article->save();

        return redirect()->route('admin.articles.index')->with('admin_success', 'Article saved.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', ['item' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $article->fill($this->validatedData($request));
        $this->handleCover($request, $article);
        $article->save();

        return redirect()->route('admin.articles.index')->with('admin_success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')->with('admin_success', 'Article deleted.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|alpha_dash',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'tags' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        $data['is_published'] = $request->boolean('is_published');

        if (empty($data['slug'])) {
            unset($data['slug']);
        }

        return $data;
    }

    private function handleCover(Request $request, Article $article): void
    {
        $request->validate([
            'cover_image' => [
                'nullable', 'file', 'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
                'dimensions:min_width=400,min_height=200,max_width=4000,max_height=4000',
            ],
            'remove_cover_image' => 'nullable|boolean',
        ]);

        if ($request->boolean('remove_cover_image') && $article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
            $article->cover_image = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $article->cover_image = $request->file('cover_image')->store('articles/covers', 'public');
        }
    }
}
