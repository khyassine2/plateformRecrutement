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
        Schema::create('resultat_tests', function (Blueprint $table) {
            $table->id('idResultatTest');
            $table->integer('scoreTest');
            $table->date('dateTest');
            $table->unsignedBigInteger('hasEntrepriseId')->nullable();
            $table->unsignedBigInteger('utilisateurId')->nullable();
            $table->foreign('utilisateurId')->references('idUtilisateur')->on('utilisateur');
            $table->unsignedBigInteger('hasSecteurId')->nullable();
            $table->foreign('hasSecteurId')->references('secteurId')->on('entreprise_has_secteurs');
            $table->foreign('hasEntrepriseId')->references('entrepriseId')->on('entreprise_has_secteurs');
            $table->unsignedBigInteger('adminId')->nullable();
            $table->foreign('adminId')->references('idUtilisateur')->on('utilisateur')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('TestId');
            $table->foreign('TestId')->references('idTest')->on('test_competences')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultat_tests');
    }
};
