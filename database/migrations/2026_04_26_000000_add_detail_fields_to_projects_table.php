<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->text('long_description')->nullable()->after('description');
            $table->string('live_url')->nullable()->after('company_badge');
            $table->string('github_url')->nullable()->after('live_url');
            $table->string('cover_image')->nullable()->after('github_url');
            $table->json('images')->nullable()->after('cover_image');
            $table->json('key_features')->nullable()->after('images');
            $table->string('role')->nullable()->after('key_features');
            $table->string('duration')->nullable()->after('role');
            $table->string('client')->nullable()->after('duration');
            $table->unsignedInteger('view_count')->default(0)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'long_description',
                'live_url',
                'github_url',
                'cover_image',
                'images',
                'key_features',
                'role',
                'duration',
                'client',
                'view_count',
            ]);
        });
    }
};
