<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp_participants extends Model
{
	protected $table = 'mps_participants';
	
	public function mp_sujet()
	{
		return $this->belongsTo('App\Mp_sujet');
	}
}
