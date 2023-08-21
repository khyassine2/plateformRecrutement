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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id('idCandidature');
            $table->date('dateCandidatures');
            $table->text('competenceQualification');
            $table->unsignedBigInteger('utilisateurId');
            $table->unsignedBigInteger('offreId');
            $table->foreign('utilisateurId')->references('idUtilisateur')->on('utilisateur')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('offreId')->references('idOffre')->on('offres')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
