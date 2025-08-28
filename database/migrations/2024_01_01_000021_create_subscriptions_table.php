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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subscription_packages_id')->constrained('subscription_packages')->onDelete('cascade');
            $table->string('name');
            $table->string('stripe_plan')->nullable();
            $table->decimal('amount', 10, 2);
            $table->integer('quantity')->default(1);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'cancelled', 'expired'])->default('active');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['instructor_id']);
            $table->index(['subscription_packages_id']);
            $table->index(['status']);
            $table->index(['start_at']);
            $table->index(['end_at']);
            $table->index(['trial_ends_at']);
            $table->index(['stripe_plan']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};