<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use App\Mp;
use App\Mp_participants;

class mpPrivate
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
		$id_mp = $request->id;

		$count = Mp_participants::where('id_mp', $id_mp)
		->where('utilisateurs_id', Auth::user()->id)
		->count();

		if($count > 0)
		{
        	return $next($request);
		}

		else
		{
			return back()->with('error', "Vous ne faites pas partie des participants de ce message privé.");
		}
    }
}
