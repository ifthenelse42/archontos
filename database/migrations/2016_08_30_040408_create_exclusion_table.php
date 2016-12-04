<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExclusionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* TYPES D'EXCLUSIONS :
		1 : TEMPORAIRE
		2 : DEFINITIF
		3 : LOCK
		*/
		Schema::create('exclusion', function (Blueprint $table) {
            $table->increments('id');

		 	$table->integer('utilisateurs_id')->unsigned();
			$table->foreign('utilisateurs_id')
			->references('id')
			->on('utilisateurs')
			->onDelete('cascade');

			$table->integer('byUtilisateurs_id')->unsigned();
			$table->foreign('byUtilisateurs_id')
			->references('id')
			->on('utilisateurs')
			->onDelete('cascade');

			$table->integer('forum_id')->unsigned();
			$table->integer('message_id')->unsigned();
			$table->smallInteger('definitive');
			$table->smallInteger('type');
			$table->timestamp('remain');

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
        Schema::drop('exclusion');
    }
}
