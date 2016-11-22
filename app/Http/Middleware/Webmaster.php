<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Webmaster
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
		if(Auth::check() && Auth::user()->level == 4 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
		{
			return $next($request);
		}

        return back()->with('error', "Vous n'avez pas le droit d'accéder à cette page.");
    }
}
