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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->enum('payment_method', ['stripe', 'bkash', 'nogod', 'rocket', 'cash', 'free'])->default('stripe');
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('sender_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->json('payment_details')->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled', 'deleted'])->default('active');
            $table->decimal('amount', 10, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id']);
            $table->index(['course_id']);
            $table->index(['instructor_id']);
            $table->index(['payment_method']);
            $table->index(['payment_status']);
            $table->index(['status']);
            $table->index(['is_manual']);
            $table->index(['payment_date']);
            $table->index(['transaction_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};