<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message_historique extends Model
{
    protected $table = 'message_historique';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
