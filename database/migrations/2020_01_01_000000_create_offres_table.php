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
        Schema::create('offres', function (Blueprint $table) {
            $table->id('idOffre');
            $table->string('titreOffre');
            $table->text('descriptionOffre');
            $table->string('competenceRequise');
            $table->integer('RemunurationPropose');
            $table->enum('typeOffre',['stage','emploi']);
            $table->date('datePublie');
            $table->date('dateCloture');
            $table->unsignedBigInteger('hasEntrepriseId');
            $table->unsignedBigInteger('hasSecteurId');
            $table->foreign('hasSecteurId')->references('secteurId')->on('entreprise_has_secteurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hasEntrepriseId')->references('entrepriseId')->on('entreprise_has_secteurs')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
