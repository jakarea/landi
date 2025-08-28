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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('promo_video')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->text('categories')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('hascertificate')->default(false);
            $table->string('sample_certificates')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('allow_review')->default(true);
            $table->boolean('auto_complete')->default(false);
            $table->string('language')->default('Bangla');
            $table->string('platform')->nullable();
            $table->text('objective')->nullable();
            $table->text('who_should_join')->nullable();
            $table->longText('curriculum')->nullable();
            $table->longText('objective_details')->nullable();
            $table->integer('numbershow')->default(0);
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id']);
            $table->index(['instructor_id']);
            $table->index(['status']);
            $table->index(['price']);
            $table->index(['offer_price']);
            $table->index(['created_at']);
            $table->fullText(['title', 'short_description', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};