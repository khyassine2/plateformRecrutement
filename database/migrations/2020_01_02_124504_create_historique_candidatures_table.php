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
        Schema::create('historique_candidatures', function (Blueprint $table) {
            $table->id('idHistorique');
            $table->enum('status',['en attente','en discussion']);
            $table->date('dateSoumission');
            $table->unsignedBigInteger('candidatureId');
            $table->foreign('candidatureId')->references('idCandidature')->on('candidatures')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_candidatures');
    }
};
