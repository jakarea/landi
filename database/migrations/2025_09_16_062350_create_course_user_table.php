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
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('instructor_id');
            $table->enum('payment_method', ['bkash', 'nogod', 'rocket', 'cash', 'free_access'])->default('cash');
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->decimal('original_amount', 10, 2)->nullable();
            $table->string('promo_code', 50)->nullable();
            $table->decimal('promo_discount', 10, 2)->default(0.00);
            $table->boolean('paid')->default(false);
            $table->enum('status', ['payment_pending', 'pending', 'approved', 'rejected'])->default('payment_pending');
            $table->string('payment_screenshot')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
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
