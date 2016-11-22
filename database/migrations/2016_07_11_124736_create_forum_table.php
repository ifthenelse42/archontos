<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('forum', function (Blueprint $table) {
            $table->increments('id');

			$table->integer('categorie_id')->unsigned();
			$table->foreign('categorie_id')
			->references('id')
			->on('forum_categorie')
			->onDelete('cascade');

            $table->string('nom', 50);
            $table->longText('description');
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
        Schema::drop('forum');
    }
}
