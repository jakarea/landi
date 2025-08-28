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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->string('file')->nullable();
            $table->string('file_extension', 10)->nullable();
            $table->enum('file_type', ['image', 'video', 'audio', 'document', 'other'])->nullable();
            $table->enum('message_type', ['text', 'file', 'image', 'video', 'audio'])->default('text');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['sender_id']);
            $table->index(['receiver_id']);
            $table->index(['group_id']);
            $table->index(['message_type']);
            $table->index(['is_read']);
            $table->index(['read_at']);
            $table->index(['created_at']);
            
            // Check constraint to ensure either receiver_id or group_id is set for proper chat routing
            $table->check('(receiver_id IS NOT NULL AND group_id IS NULL) OR (receiver_id IS NULL AND group_id IS NOT NULL)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};