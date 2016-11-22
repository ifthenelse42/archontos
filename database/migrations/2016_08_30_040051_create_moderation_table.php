<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModerationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('moderation', function (Blueprint $table) {
            $table->increments('id');

		 	$table->integer('utilisateurs_id')->unsigned();
			$table->foreign('utilisateurs_id')
			->references('id')
			->on('utilisateurs')
			->onDelete('cascade');

			$table->integer('forum_id')->unsigned();
			$table->foreign('forum_id')
			->references('id')
			->on('forum')
			->onDelete('cascade');

             $table->string('secret_password');
			 $table->timestamp('mandat_debut');
			 $table->timestamp('mandat_fin');
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
        Schema::drop('moderation');
    }
}
