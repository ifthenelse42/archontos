<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if(Auth::check() && Auth::user()->level >= 3 && !session()->has('admins_unlock'))
		{
			return $next($request);
		}

		return redirect('http://rickrolled.fr/'); // :D
        //return redirect('/')->with('error', "Vous n'avez pas le droit d'accéder à cette page.");
    }
}
