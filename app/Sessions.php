<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
	protected $table = 'sessions';

	public function utilisateurs()
    {
        return $this->belongsTo('App\User');
    }

	protected $hidden = [
        'ip',
    ];
}
