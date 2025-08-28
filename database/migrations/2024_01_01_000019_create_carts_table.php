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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('user_identifier')->nullable(); // For guest users
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->foreignId('bundle_course_id')->nullable()->constrained('bundle_courses')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id']);
            $table->index(['user_identifier']);
            $table->index(['course_id']);
            $table->index(['bundle_course_id']);
            $table->index(['created_at']);
            
            // Check constraint to ensure either course_id or bundle_course_id is set
            $table->check('(course_id IS NOT NULL AND bundle_course_id IS NULL) OR (course_id IS NULL AND bundle_course_id IS NOT NULL)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};