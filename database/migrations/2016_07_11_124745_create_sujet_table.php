<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSujetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 public function up()
     {
 		Schema::create('sujet', function (Blueprint $table) {
             $table->increments('id');

			 $table->integer('forum_id')->unsigned();
			 $table->foreign('forum_id')
			 ->references('id')
			 ->on('forum')
			 ->onDelete('cascade');

		 	$table->integer('utilisateurs_id')->unsigned();
			$table->foreign('utilisateurs_id')
			->references('id')
			->on('utilisateurs')
			->onDelete('cascade');

             $table->string('titre', 500);
			 $table->enum('status', [0,1,2]);
			 $table->enum('ouvert', [0,1]);
			 $table->enum('anonymous', [0,1]);
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
         Schema::drop('sujet');
     }
}
