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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reflection_id');
            $table->unsignedBigInteger('evaluator_id'); // Admin who evaluated
            $table->integer('evaluation_score');
            $table->string('evaluation_type');
            $table->text('evaluation_comments');
            $table->timestamp('evaluated_at');
            $table->timestamps();

            $table->foreign('reflection_id')->references('id')->on('reflections')->onDelete('cascade');
            $table->foreign('evaluator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
