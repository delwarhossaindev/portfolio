<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioContent;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin editor for the homepage hero, about, contact details and SEO settings.
 */
class HomeContentController extends Controller
{
    public function edit()
    {
        return view('admin.home', ['content' => PortfolioContent::current()]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_greeting' => 'required|string|max:255',
            'hero_name' => 'required|string|max:255',
            'hero_roles' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:255',
            'contact_location' => 'required|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'profile_image' => [
                'nullable', 'file', 'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
                'dimensions:min_width=200,min_height=200,max_width=4000,max_height=4000',
            ],
            'remove_profile_image' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'twitter_handle' => ['nullable', 'string', 'max:50', 'regex:/^@?[A-Za-z0-9_]{1,30}$/'],
            'site_url' => 'nullable|url|max:255',
            'og_image' => [
                'nullable', 'file', 'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
                'dimensions:min_width=600,min_height=315,max_width=4000,max_height=4000',
            ],
            'remove_og_image' => 'nullable|boolean',
        ]);

        $content = PortfolioContent::current();

        // Profile photo: 800px is plenty for the round hero avatar.
        $this->replaceImage($request, $content, 'profile_image', 'portfolio', 800, 85);
        // Social share image: 1200px wide is what Facebook/LinkedIn/X render.
        $this->replaceImage($request, $content, 'og_image', 'portfolio/og', 1200, 88);

        $content->fill(collect($validated)
            ->except(['profile_image', 'remove_profile_image', 'og_image', 'remove_og_image'])
            ->all());
        $content->save();

        return back()->with('admin_success', 'Portfolio content updated successfully.');
    }

    private function replaceImage(Request $request, PortfolioContent $content, string $field, string $folder, int $maxDim, int $quality): void
    {
        $remove = $request->boolean('remove_' . $field);
        $upload = $request->file($field);

        if (($remove || $upload) && $content->{$field}) {
            Storage::disk('public')->delete($content->{$field});
            $content->{$field} = null;
        }

        if ($upload) {
            $content->{$field} = ImageOptimizer::store($upload, $folder, $maxDim, $quality);
        }
    }
}
