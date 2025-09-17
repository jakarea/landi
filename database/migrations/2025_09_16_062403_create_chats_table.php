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
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->longText('message')->nullable();
            $table->string('file')->nullable();
            $table->string('file_extension', 50)->nullable();
            $table->tinyInteger('file_type')->default(1)->comment('1:Message, 2:File');
            $table->tinyInteger('message_type')->default(1)->comment('1:Personal message, 2:Group message');
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
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
