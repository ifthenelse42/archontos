<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MpsSujet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('mps_sujets', function (Blueprint $table) {
            $table->increments('id')->unique();

			$table->integer('utilisateurs_id')->unsigned();
			$table->foreign('utilisateurs_id')
			->references('id')
			->on('utilisateurs')
			->onDelete('cascade');
			$table->string('titre', 50);
			$table->smallInteger('status');
			$table->smallInteger('ouvert');
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
        Schema::drop('mps_sujets');
    }
}
