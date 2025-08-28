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
        Schema::create('manage_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('show_in_menu')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status']);
            $table->index(['show_in_menu']);
            $table->index(['sort_order']);
            $table->index(['created_at']);
            $table->fullText(['title', 'content', 'meta_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_pages');
    }
};