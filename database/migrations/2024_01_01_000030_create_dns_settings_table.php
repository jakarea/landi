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
        Schema::create('dns_settings', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->enum('type', ['A', 'AAAA', 'CNAME', 'MX', 'TXT', 'NS'])->default('A');
            $table->string('value');
            $table->integer('ttl')->default(3600);
            $table->integer('priority')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['domain']);
            $table->index(['type']);
            $table->index(['status']);
            $table->index(['created_by']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dns_settings');
    }
};