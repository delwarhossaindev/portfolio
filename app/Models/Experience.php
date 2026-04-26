<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'role',
        'company',
        'location',
        'date_range',
        'description',
        'technologies',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => \Illuminate\Support\Facades\Cache::forget('portfolio.experiences'));
        static::deleted(fn () => \Illuminate\Support\Facades\Cache::forget('portfolio.experiences'));
    }

    public function techList(): array
    {
        return collect(explode(',', (string) $this->technologies))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }
}
