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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_question_id')
                ->nullable() // Ensure it's nullable before constraints
                ->constrained('survey_questions')
                ->nullOnDelete(); // Ensures it's NULL instead of deletion
            $table->enum('response_type', ['happy', 'moderate', 'angry', 'sad'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
