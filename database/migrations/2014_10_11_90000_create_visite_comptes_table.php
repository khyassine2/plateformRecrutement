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
        Schema::create('visite_comptes', function (Blueprint $table) {
            $table->id('idVisiteCompte');
            $table->unsignedBigInteger('visiteCompteId');
            $table->unsignedBigInteger('connecteCompteId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visite_comptes');
    }
};
