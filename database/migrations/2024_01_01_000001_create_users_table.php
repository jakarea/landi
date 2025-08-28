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
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_role', ['admin', 'instructor', 'student'])->default('student');
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->text('short_bio')->nullable();
            $table->json('social_links')->nullable();
            $table->string('company_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('recivingMessage')->default(true);
            $table->timestamp('last_activity_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_role']);
            $table->index(['email_verified_at']);
            $table->index(['last_activity_at']);
            $table->index(['created_at']);
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