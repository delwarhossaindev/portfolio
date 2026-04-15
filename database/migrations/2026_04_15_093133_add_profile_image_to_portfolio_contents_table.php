<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_contents', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('hero_description');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('portfolio_contents', 'profile_image')) {
            Schema::table('portfolio_contents', function (Blueprint $table) {
                $table->dropColumn('profile_image');
            });
        }
    }
};
