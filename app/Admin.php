<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements AuthenticatableContract
{
	use Authenticatable;

	protected $table = 'admin';
	protected $guard = 'admins';

	protected $fillable = [
	    'secret_password',
	];

	protected $hidden = [
        'secret_password',
    ];
}
