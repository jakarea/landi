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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('id', 36)->unique(); // UUID for Laravel notifications
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Custom fields for LMS notifications
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->enum('status', ['unread', 'read', 'archived'])->default('unread');
            $table->enum('type_custom', ['enrollment', 'payment', 'course', 'system', 'announcement'])->nullable();
            
            // Indexes for performance
            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index(['instructor_id']);
            $table->index(['course_id']);
            $table->index(['user_id']);
            $table->index(['status']);
            $table->index(['type_custom']);
            $table->index(['read_at']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};