<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_contents', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('hero_description');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            $table->string('og_image')->nullable()->after('meta_keywords');
            $table->string('twitter_handle')->nullable()->after('og_image');
            $table->string('site_url')->nullable()->after('twitter_handle');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_contents', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'og_image',
                'twitter_handle',
                'site_url',
            ]);
        });
    }
};
