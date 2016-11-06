<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{
	protected $table = 'moderation';

	public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function forum()
    {
        return $this->belongsTo('App\Forum');
    }
}
