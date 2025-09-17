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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('course_id');
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('duration')->default(0);
            $table->integer('module_id');
            $table->text('title');
            $table->text('slug');
            $table->string('video_link', 191)->nullable();
            $table->string('video_type', 20)->default('vimeo');
            $table->string('thumbnail', 191)->nullable();
            $table->text('short_description')->nullable();
            $table->string('status', 30)->default('pending');
            $table->boolean('is_public')->default(false);
            $table->enum('type', ['video', 'audio', 'text', 'live']);
            $table->dateTime('live_start_time')->nullable();
            $table->integer('live_duration_minutes')->nullable();
            $table->string('zoom_meeting_id')->nullable();
            $table->string('zoom_join_url')->nullable();
            $table->string('zoom_password')->nullable();
            $table->string('audio')->nullable();
            $table->string('text')->nullable();
            $table->string('lesson_file')->nullable();
            $table->integer('reorder')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
