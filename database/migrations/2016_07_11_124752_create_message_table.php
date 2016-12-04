<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 public function up()
     {
 		Schema::create('message', function (Blueprint $table) {
             $table->increments('id');

			 $table->integer('sujet_id')->unsigned();
			 $table->foreign('sujet_id')
			 ->references('id')
			 ->on('sujet')
			 ->onDelete('cascade');

			 $table->integer('utilisateurs_id')->unsigned();
			 $table->foreign('utilisateurs_id')
			 ->references('id')
			 ->on('utilisateurs')
			 ->onDelete('cascade');

             $table->longText('contenu');
			 $table->smallInteger('status');
			 $table->smallInteger('anonymous');
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
         Schema::drop('message');
     }
}
