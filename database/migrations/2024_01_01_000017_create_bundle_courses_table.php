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
        Schema::create('bundle_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->string('slug')->unique();
            $table->json('selected_course')->nullable(); // Course IDs as JSON array
            $table->decimal('regular_price', 10, 2);
            $table->decimal('sales_price', 10, 2)->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['instructor_id']);
            $table->index(['status']);
            $table->index(['regular_price']);
            $table->index(['sales_price']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_courses');
    }
};