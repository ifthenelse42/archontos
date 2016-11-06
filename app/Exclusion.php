<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exclusion extends Model
{
	protected $table = 'exclusion';

	public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function forum()
    {
        return $this->belongsTo('App\Forum');
    }

	public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
