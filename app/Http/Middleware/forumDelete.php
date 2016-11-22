<?php

namespace App\Http\Middleware;

use Closure;
use App\Sujet;
use Auth;

class forumDelete
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
		if(!$request->isMethod('post') && Sujet::find($request->id)->status == 0 && Auth::check() && Auth::user()->level < 3)
		{
			return redirect('error')->with('error', "Ce sujet n'est pas accessible.");
		}

		return $next($request);
    }
}
