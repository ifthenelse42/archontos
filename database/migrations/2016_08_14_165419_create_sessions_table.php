<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');

			$table->integer('utilisateurs_id')->unsigned(); // ON NE LIE PAS A LA TABLE UTILISATEURS_ID POUR LES NON CONNECTES

			$table->text('location'); // doit être l'équivalent de Request::param(1)
			$table->integer('location_id')->unsigned(); // si c'est dans un sujet, alors c'est l'id ... etc
			$table->smallInteger('invisible');
			$table->ipAddress('ip');
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
        Schema::drop('sessions');
    }
}
