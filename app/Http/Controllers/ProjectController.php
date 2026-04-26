<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.projects.index', [
            'items' => Project::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.projects.form', [
            'item' => new Project(['icon' => 'fas fa-folder-open', 'is_active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $project = new Project($this->validatedData($request));
        $this->handleUploads($request, $project);
        $project->save();

        return redirect()->route('admin.projects.index')->with('admin_success', 'Project added.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', ['item' => $project]);
    }

    public function update(Request $request, Project $project)
    {
        $project->fill($this->validatedData($request));
        $this->handleUploads($request, $project);
        $project->save();

        return redirect()->route('admin.projects.index')->with('admin_success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
        }
        foreach (($project->images ?? []) as $img) {
            Storage::disk('public')->delete($img);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('admin_success', 'Project deleted.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|alpha_dash',
            'description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'company_badge' => 'nullable|string|max:100',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'role' => 'nullable|string|max:150',
            'duration' => 'nullable|string|max:150',
            'client' => 'nullable|string|max:150',
            'icon' => 'nullable|string|max:100',
            'technologies' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'key_features' => 'nullable|string',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['icon'] = $data['icon'] ?: 'fas fa-folder-open';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if (! empty($data['key_features'])) {
            $data['key_features'] = collect(preg_split('/\r?\n/', $data['key_features']))
                ->map(fn ($line) => trim($line))
                ->filter()
                ->values()
                ->all();
        } else {
            $data['key_features'] = [];
        }

        if (empty($data['slug'])) {
            unset($data['slug']);
        }

        return $data;
    }

    private function handleUploads(Request $request, Project $project): void
    {
        $request->validate([
            'cover_image' => [
                'nullable',
                'file',
                'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
                'dimensions:min_width=200,min_height=100,max_width=4000,max_height=4000',
            ],
            'images.*' => [
                'nullable',
                'file',
                'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
                'dimensions:min_width=200,min_height=100,max_width=4000,max_height=4000',
            ],
            'images' => 'nullable|array|max:20',
            'remove_cover_image' => 'nullable|boolean',
            'remove_image_index' => 'nullable|array|max:50',
            'remove_image_index.*' => 'integer|min:0',
        ]);

        if ($request->boolean('remove_cover_image') && $project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
            $project->cover_image = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $project->cover_image = $request->file('cover_image')->store('projects/covers', 'public');
        }

        $existingImages = $project->images ?? [];

        $removeIndices = $request->input('remove_image_index', []);
        if (! empty($removeIndices)) {
            foreach ($removeIndices as $index) {
                if (isset($existingImages[$index])) {
                    Storage::disk('public')->delete($existingImages[$index]);
                    unset($existingImages[$index]);
                }
            }
            $existingImages = array_values($existingImages);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $existingImages[] = $file->store('projects/screenshots', 'public');
                }
            }
        }

        $project->images = $existingImages;
    }
}
