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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->decimal('original_amount', 8, 2);
            $table->decimal('discount_amount', 8, 2);
            $table->decimal('final_amount', 8, 2);
            $table->timestamps();

            $table->unique(['coupon_id', 'user_id', 'course_id']);
            $table->index(['coupon_id', 'created_at']);
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
