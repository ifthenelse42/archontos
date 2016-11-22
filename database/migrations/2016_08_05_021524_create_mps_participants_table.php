<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpsParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mps_participants', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->integer('id_mp')->unsigned();
			$table->foreign('id_mp')
			->references('id')
			->on('mps_sujets')
			->onDelete('cascade');

			$table->integer('utilisateurs_id')->unsigned();
			$table->foreign('utilisateurs_id')
			->references('id')
			->on('utilisateurs')
			->onDelete('cascade');

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
        Schema::drop('mps_participants');
    }
}
