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
        Schema::create('reflections', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id'); 
            $table->unsignedBigInteger('seminar_id');
            $table->text('comment');
            $table->string('document_path')->nullable();
            $table->boolean('is_evaluated')->default(false);
            $table->timestamps();
            $table->foreign('seminar_id')->references('id')->on('video_hr2s');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('reflections');
    }
};
