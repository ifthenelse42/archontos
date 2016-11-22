<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageHistoriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_historique', function (Blueprint $table) {
             $table->increments('id');

			 $table->integer('message_id')->unsigned();
			 $table->foreign('message_id')
			 ->references('id')
			 ->on('message')
			 ->onDelete('cascade');

			 $table->integer('utilisateurs_id')->unsigned();
			 $table->foreign('utilisateurs_id')
			 ->references('id')
			 ->on('utilisateurs')
			 ->onDelete('cascade');

             $table->longText('contenu');
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
        Schema::drop('message_historique');
    }
}
