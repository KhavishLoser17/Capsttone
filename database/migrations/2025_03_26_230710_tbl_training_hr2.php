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
        Schema::create('tbl_training_hr2', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('instructor');
            $table->string('department');
            $table->string('goals');
            $table->datetime('date');
            $table->datetime('dueDate');
            $table->decimal('budget', 10, 2);
            $table->string('image')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_training_hr2'); // Add this to properly drop the table
    }
};
