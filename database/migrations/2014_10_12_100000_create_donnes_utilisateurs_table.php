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
        Schema::create('donnes_utilisateurs', function (Blueprint $table) {
            $table->id('idDonnes');
            $table->text('cv');
            $table->text('experiances');
            $table->text('competences');
            $table->text('niveauEtude');
            $table->unsignedBigInteger('utilisateurId')->nullable();
            $table->foreign('utilisateurId')->references('idUtilisateur')->on('utilisateur')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donnes_utilisateurs');
    }
};
