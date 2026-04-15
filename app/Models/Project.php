<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'company_badge',
        'icon',
        'technologies',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function techList(): array
    {
        return collect(explode(',', (string) $this->technologies))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }
}
