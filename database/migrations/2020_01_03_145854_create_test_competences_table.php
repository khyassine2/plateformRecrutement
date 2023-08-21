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
        Schema::create('test_competences', function (Blueprint $table) {
            $table->id('idTest');
            $table->string('titreTest');
            $table->string('descriptionTest');
            $table->integer('duree');
            $table->integer('ajouterPar');
            $table->enum('type',['admin','entreprise']);
            $table->unsignedBigInteger('utilisateurId');
            $table->unsignedBigInteger('hasEntrepriseId');
            $table->unsignedBigInteger('hasSecteurId');
            $table->foreign('hasSecteurId')->references('secteurId')->on('entreprise_has_secteurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hasEntrepriseId')->references('entrepriseId')->on('entreprise_has_secteurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('utilisateurId')->references('idUtilisateur')->on('utilisateur')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_competences');
    }
};
