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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id("idEntreprise");
            $table->string("nomEntreprise");
            $table->string("adresseEntreprise");
            $table->string("emailEntreprise");
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string("siteWebEntreprise");
            $table->string("villeEntreprise");
            $table->string("telephone");
            $table->text("photo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
