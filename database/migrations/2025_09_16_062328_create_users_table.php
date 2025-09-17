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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('user_role')->default('student');
            $table->text('company_name')->nullable();
            $table->text('short_bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('social_links')->nullable();
            $table->longText('description')->nullable();
            $table->string('recivingMessage')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('vimeo_data')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->string('bkash_number')->nullable();
            $table->string('nogod_number')->nullable();
            $table->string('rocket_number')->nullable();
            $table->string('stripe_public_key')->nullable();
            $table->string('session_id')->nullable();
            $table->string('status')->default('active');
            $table->timestamp('last_activity_at')->nullable()->comment('User last activity');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
