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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('topic');
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->enum('type', ['multiple-choice', 'true-false', 'short-answer']);
            $table->text('question_text');
            $table->text('answer')->nullable();
            $table->text('explanation')->nullable();
            $table->json('options')->nullable(); // For multiple choice
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
