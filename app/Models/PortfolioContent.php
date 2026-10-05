<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Single-row table holding the editable homepage content and SEO settings.
 */
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

    /** Values used the first time the site runs, before anything is edited in the admin. */
    public const DEFAULTS = [
        'hero_greeting' => "Hi I'm",
        'hero_name' => 'Delwar Hossain',
        'hero_roles' => 'Full Stack Developer',
        'hero_description' => 'Full Stack Developer with over 5 years of experience in PHP, Laravel, and Vue JS. I have demonstrated expertise in developing and optimizing web applications. I am passionate about writing clean and scalable code.',
        'about_title' => 'About me',
        'about_description' => 'I am a Full Stack Developer with over 5 years of experience in PHP, Laravel, and Vue JS. I hold a Bachelor of Science in Computer Science & Engineering from BAIUST. Currently working as a Software Engineer at ACI Limited in Dhaka.',
        'contact_email' => 'delwarhossain1103104@gmail.com',
        'contact_phone' => '+8801797384242',
        'contact_location' => 'Mirpur-12, Dhaka, Bangladesh',
        'linkedin_url' => 'https://www.linkedin.com/in/delwarhossaindev/',
        'github_url' => 'https://github.com/delwarhossaindev',
    ];

    /** The one content row, created with defaults if it doesn't exist yet. */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], self::DEFAULTS);
    }
}
