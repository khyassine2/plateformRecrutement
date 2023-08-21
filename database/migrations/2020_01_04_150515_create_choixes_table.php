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
        Schema::create('choix', function (Blueprint $table) {
            $table->id('idChoix');
            $table->text('enonce');
            $table->tinyInteger('isCorrect');
            $table->unsignedBigInteger('questionId');
            $table->foreign('questionId')->references('idQuestion')->on('questions')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choixes');
    }
};
