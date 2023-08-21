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
        Schema::create('entreprise_has_secteurs', function (Blueprint $table) {
            $table->unsignedBigInteger('entrepriseId');
            $table->unsignedBigInteger('secteurId');
            $table->primary(['entrepriseId','secteurId']);
            $table->foreign('secteurId')->references('idSecteurActiviter')->on('secteur_activiters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('entrepriseId')->references('idEntreprise')->on('entreprises')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprise_has__secteurs');
    }
};
