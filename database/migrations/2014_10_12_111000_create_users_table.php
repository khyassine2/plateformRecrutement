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
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id('idUtilisateur');
            $table->string('nomUtilisateur');
            $table->string('prenomUtilisateur');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone');
            $table->string('ville');
            $table->date('dateNaissance');
            $table->text('photo');
            $table->unsignedBigInteger('Role_id')->nullable();
            $table->unsignedBigInteger('levelsite_id')->nullable();
            $table->foreign('Role_id')->references('idRole')->on('roles')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('levelsite_id')->references('idLevelSite')->on('level_sites')->onDelete('set null')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
