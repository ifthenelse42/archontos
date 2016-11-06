<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
	protected $fillable = ['contenu','sujet_id'];


    public function sujet()
    {
        return $this->belongsTo('App\Sujet');
    }

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
