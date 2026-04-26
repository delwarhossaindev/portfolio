<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioContent extends Model
{
    protected $fillable = [
        'hero_greeting',
        'hero_name',
        'hero_roles',
        'hero_description',
        'profile_image',
        'about_title',
        'about_description',
        'contact_email',
        'contact_phone',
        'contact_location',
        'linkedin_url',
        'github_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'twitter_handle',
        'site_url',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => \Illuminate\Support\Facades\Cache::forget('portfolio.content'));
    }
}
