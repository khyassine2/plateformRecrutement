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
        Schema::create('reponse_candidats', function (Blueprint $table) {
            $table->id('idReponseCandidat');
            $table->text('reponseCandidat');
            $table->unsignedBigInteger('choixId');
            $table->unsignedBigInteger('utilisateurId');
            $table->foreign('utilisateurId')->references('idUtilisateur')->on('utilisateur');
            $table->foreign('choixId')->references('idchoix')->on('choix');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reponse_candidats');
    }
};
