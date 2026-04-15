<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return view('admin.experiences.index', [
            'items' => Experience::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.experiences.form', [
            'item' => new Experience(['icon' => 'fas fa-briefcase', 'is_active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Experience::create($data);

        return redirect()->route('admin.experiences.index')->with('admin_success', 'Experience added.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.form', ['item' => $experience]);
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $this->validated($request);
        $experience->update($data);

        return redirect()->route('admin.experiences.index')->with('admin_success', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('admin_success', 'Experience deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'role' => 'required|string|max:150',
            'company' => 'required|string|max:150',
            'location' => 'nullable|string|max:200',
            'date_range' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'technologies' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['icon'] = $data['icon'] ?: 'fas fa-briefcase';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
