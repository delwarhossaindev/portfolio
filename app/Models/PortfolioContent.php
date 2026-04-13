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
        'about_title',
        'about_description',
        'contact_email',
        'contact_phone',
        'contact_location',
        'linkedin_url',
        'github_url',
    ];
}
