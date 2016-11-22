<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtilisateursTable extends Migration
{
	/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pseudo', 20)->unique();
            $table->string('email')->unique();
            $table->string('password');

			// Colonnes d'administration et modération \\
			$table->enum('level', [0,1,2,3,4]);

			/*
			>>>>>>> HIERARCHIE DES NIVEAUX D'ACCES <<<<<<<
			- NIVEAU 0 = NON VALIDE/BANNI
			- NIVEAU 1 = MEMBRE
			- NIVEAU 2 = MODERATEUR
			- NIVEAU 3 = ADMINISTRATEUR
			- NIVEAU 4 = WEBMASTER - IFTHENELSE
			*/

			// Informations non essentielles
			$table->string('avatar'); // url vers l'avatar

			// Profil
			$table->string('presentation');
			$table->enum('activity', [0,1]);

			// Options
			$table->enum('invisible', [0,1]);
			$table->enum('anonymous', [0,1]);

			// ---------------------------------------- \\
			$table->ipAddress('ip')->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }

	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('utilisateurs');
    }
}
