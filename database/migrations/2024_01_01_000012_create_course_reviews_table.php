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
        Schema::create('course_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->tinyInteger('star')->unsigned()->default(5);
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['course_id']);
            $table->index(['user_id']);
            $table->index(['instructor_id']);
            $table->index(['star']);
            $table->index(['created_at']);
            $table->unique(['course_id', 'user_id']);
            
            // Check constraint for star rating
            $table->check('star >= 1 AND star <= 5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_reviews');
    }
};