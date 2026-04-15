<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

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
        Project::create($this->validated($request));

        return redirect()->route('admin.projects.index')->with('admin_success', 'Project added.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', ['item' => $project]);
    }

    public function update(Request $request, Project $project)
    {
        $project->update($this->validated($request));

        return redirect()->route('admin.projects.index')->with('admin_success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('admin_success', 'Project deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'company_badge' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'technologies' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['icon'] = $data['icon'] ?: 'fas fa-folder-open';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
