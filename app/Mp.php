<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp extends Model
{
	protected $table = 'mps';
	protected $fillable = ['contenu'];

	public $incrementing = true;

	public function utilisateurs()
    {
        return $this->belongsTo('App\User');
    }

	public function mp_sujet()
    {
        return $this->belongsTo('App\Mp_sujet');
    }
}
