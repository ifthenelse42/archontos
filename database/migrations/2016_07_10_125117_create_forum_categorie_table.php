<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('forum_categorie', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 50);
			/*
			TYPE 0 = EXIL
			TYPE 1 = TOUS
			TYPE 2 = CONNECTE UNIQUEMENT
			TYPE 3 = MODERATION
			*/
			$table->smallInteger('type');
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
        Schema::drop('forum_categorie');
    }
}
