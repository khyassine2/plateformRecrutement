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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id('idDiscussion');
            $table->date('dateDiscussion');
            $table->unsignedBigInteger('utilisateurId');
            $table->unsignedBigInteger('entrepriseId');
            $table->foreign('entrepriseId')->references('idEntreprise')->on('entreprises');
            $table->foreign('utilisateurId')->references('idUtilisateur')->on('utilisateur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
