<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_greeting')->nullable();
            $table->string('hero_name')->nullable();
            $table->string('hero_roles')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_location')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_contents');
    }
};
