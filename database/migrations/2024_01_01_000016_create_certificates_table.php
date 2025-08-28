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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('certificate_clr', 7)->default('#ffffff'); // Hex color
            $table->string('accent_clr', 7)->default('#000000'); // Hex color
            $table->string('style')->default('modern');
            $table->string('logo')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['instructor_id']);
            $table->index(['course_id']);
            $table->index(['created_at']);
            $table->unique(['course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};