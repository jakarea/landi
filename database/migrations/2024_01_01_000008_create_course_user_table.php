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
        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->enum('payment_method', ['bkash', 'nogod', 'rocket', 'cash', 'free_access'])->default('cash');
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('original_amount', 10, 2)->nullable();
            $table->string('promo_code')->nullable();
            $table->decimal('promo_discount', 10, 2)->default(0);
            $table->enum('status', ['payment_pending', 'pending', 'approved', 'rejected'])->default('payment_pending');
            $table->boolean('paid')->default(false);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->string('payment_screenshot')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['course_id']);
            $table->index(['user_id']);
            $table->index(['instructor_id']);
            $table->index(['status']);
            $table->index(['payment_method']);
            $table->index(['paid']);
            $table->index(['promo_code']);
            $table->index(['created_at']);
            $table->unique(['course_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_user');
    }
};