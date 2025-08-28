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
        Schema::create('group_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['admin', 'moderator', 'member'])->default('member');
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['group_id']);
            $table->index(['user_id']);
            $table->index(['role']);
            $table->index(['status']);
            $table->index(['joined_at']);
            $table->index(['created_at']);
            $table->unique(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_participants');
    }
};