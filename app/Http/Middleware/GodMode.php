<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Auth;

class GodMode
{
    // GOD MODE - MODE DIEU
	// PERMET D'ACCEDER AU DEBUG MODE UNIQUEMENT POUR LE WEBMASTER
    public function handle($request, Closure $next)
    {
		if(Auth::check() && Auth::user()->level == 4 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
		{
			/*Config::set('app.debug' , true);
			var_dump(Config::get('app.debug'));
			app()->startExceptionHandling();*/
		}

        return $next($request);
    }
}
