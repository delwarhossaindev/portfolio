<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'projects_active_sort_idx');
            $table->index('is_featured', 'projects_featured_idx');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'experiences_active_sort_idx');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->index('is_read', 'contacts_is_read_idx');
            $table->index('created_at', 'contacts_created_at_idx');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('projects_active_sort_idx');
            $table->dropIndex('projects_featured_idx');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropIndex('experiences_active_sort_idx');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_is_read_idx');
            $table->dropIndex('contacts_created_at_idx');
        });
    }
};
