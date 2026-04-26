<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'company_badge',
        'live_url',
        'github_url',
        'cover_image',
        'images',
        'key_features',
        'role',
        'duration',
        'client',
        'icon',
        'technologies',
        'is_featured',
        'sort_order',
        'is_active',
        'view_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'view_count' => 'integer',
        'images' => 'array',
        'key_features' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (empty($project->slug) && ! empty($project->title)) {
                $project->slug = static::generateUniqueSlug($project->title, $project->id);
            }
        });

        static::saved(fn () => \Illuminate\Support\Facades\Cache::forget('portfolio.projects'));
        static::deleted(fn () => \Illuminate\Support\Facades\Cache::forget('portfolio.projects'));
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'project';
        $slug = $base;
        $counter = 2;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function techList(): array
    {
        return collect(explode(',', (string) $this->technologies))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function coverImageUrl(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }
        return asset('storage/' . $this->cover_image);
    }

    public function imageUrls(): array
    {
        return collect($this->images ?? [])
            ->filter()
            ->map(fn ($path) => asset('storage/' . $path))
            ->values()
            ->all();
    }
}
