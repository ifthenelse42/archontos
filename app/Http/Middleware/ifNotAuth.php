<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ifNotAuth
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
		if(!Auth::check())
		{
			return redirect('error')->with('error', "Vous devez vous connecter pour accéder à cette page.");
		}

        return $next($request);
    }
}
