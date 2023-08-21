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
        Schema::create('formations', function (Blueprint $table) {
            $table->id('idFormation');
            $table->string('nomFormation');
            $table->string('descriptionFormation');
            $table->float('prix');
            $table->integer('duree');
            $table->unsignedBigInteger('CalendrierId');
            $table->unsignedBigInteger('hasEntrepriseId');
            $table->unsignedBigInteger('hasSecteurId');
            $table->foreign('hasSecteurId')->references('secteurId')->on('entreprise_has_secteurs');
            $table->foreign('hasEntrepriseId')->references('entrepriseId')->on('entreprise_has_secteurs');
            $table->foreign('CalendrierId')->references('idCalendrier')->on('calendrier_formations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
