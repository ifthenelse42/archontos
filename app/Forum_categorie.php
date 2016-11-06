<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum_categorie extends Model
{
	protected $table = 'forum_categorie';
	protected $fillable = ['titre'];
}
