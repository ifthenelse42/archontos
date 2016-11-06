<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table = 'forum';
	protected $fillable = ['titre', 'description'];

	public function categorie()
    {
        return $this->belongsTo('App\Forum_categorie');
    }
}
