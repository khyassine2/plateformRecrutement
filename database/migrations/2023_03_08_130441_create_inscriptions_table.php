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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id('idInscription');
            $table->date('dateInscription');
            $table->unsignedBigInteger('formationId');
            $table->unsignedBigInteger('utilisateurId');
            $table->foreign('formationId')->references('idFormation')->on('formations');
            $table->foreign('utilisateurId')->references('idUtilisateur')->on('utilisateur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
