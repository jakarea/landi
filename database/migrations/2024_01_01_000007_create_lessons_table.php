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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('video_link')->nullable();
            $table->enum('video_type', ['youtube', 'vimeo', 'upload', 'external'])->default('youtube');
            $table->string('thumbnail')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('duration')->default(0); // in seconds
            $table->integer('reorder')->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('type', ['video', 'text', 'quiz', 'assignment'])->default('video');
            $table->boolean('is_public')->default(false);
            $table->string('lesson_file')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id']);
            $table->index(['course_id']);
            $table->index(['instructor_id']);
            $table->index(['module_id']);
            $table->index(['status']);
            $table->index(['type']);
            $table->index(['is_public']);
            $table->index(['reorder']);
            $table->unique(['module_id', 'slug']);
            $table->fullText(['title', 'short_description']);
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