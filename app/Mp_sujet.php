<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp_sujet extends Model
{
	protected $table = 'mps_sujets';
	protected $fillable = ['titre'];
}
