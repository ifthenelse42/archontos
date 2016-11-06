<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sujet extends Model
{
    protected $table = 'sujet';
	protected $fillable = ['titre'];


    public function forum()
    {
        return $this->belongsTo('App\Forum');
    }

	public function utilisateurs()
    {
        return $this->belongsTo('App\User');
    }
}
