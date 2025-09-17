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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->text('title');
            $table->text('slug');
            $table->string('status', 30)->default('draft');
            $table->dateTime('publish_at')->nullable();
            $table->integer('reorder')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
