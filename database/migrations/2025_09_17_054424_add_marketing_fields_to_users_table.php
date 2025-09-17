<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook_pixel_id')->nullable()->after('social_links');
            $table->string('google_analytics_id')->nullable()->after('facebook_pixel_id');
            $table->string('google_tag_manager_id')->nullable()->after('google_analytics_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['facebook_pixel_id', 'google_analytics_id', 'google_tag_manager_id']);
        });
    }
};
