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
        Schema::create('bundle_selects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('bundle_course_id')->constrained('bundle_courses')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['instructor_id']);
            $table->index(['course_id']);
            $table->index(['bundle_course_id']);
            $table->index(['created_at']);
            $table->unique(['course_id', 'bundle_course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_selects');
    }
};