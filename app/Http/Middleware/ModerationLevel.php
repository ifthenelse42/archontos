<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ModerationLevel
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
 		if(Auth::check() && Auth::user()->level == 2 && !session()->has('moderation_unlock'))
 		{
 			return $next($request);
 		}

        return redirect('/')->with('error', "Vous n'avez pas le droit d'accéder à cette page.");
     }
}
