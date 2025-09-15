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
        Schema::table('lessons', function (Blueprint $table) {
            // Live lesson fields
            $table->datetime('live_start_time')->nullable()->after('type');
            $table->integer('live_duration_minutes')->nullable()->after('live_start_time');
            $table->string('zoom_meeting_id')->nullable()->after('live_duration_minutes');
            $table->string('zoom_join_url')->nullable()->after('zoom_meeting_id');
            $table->string('zoom_password')->nullable()->after('zoom_join_url');
            
            // Update type enum to include 'live'
            $table->enum('type', ['video', 'audio', 'text', 'live'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'live_start_time',
                'live_duration_minutes', 
                'zoom_meeting_id',
                'zoom_join_url',
                'zoom_password'
            ]);
            
            // Revert type enum
            $table->enum('type', ['video', 'audio', 'text'])->change();
        });
    }
};