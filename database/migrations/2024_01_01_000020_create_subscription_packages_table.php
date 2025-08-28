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
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('regular_price', 10, 2);
            $table->decimal('sales_price', 10, 2)->nullable();
            $table->json('features')->nullable(); // Features as JSON array
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->enum('type', ['monthly', 'yearly', 'lifetime'])->default('monthly');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status']);
            $table->index(['type']);
            $table->index(['created_by']);
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
        Schema::dropIfExists('subscription_packages');
    }
};