<?php

namespace App\Http\Middleware;

use Closure;

use App\Forum;
use App\Sujet;
use App\Message;

class exclusionExist
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
		if(Forum::find($request->idForum)) {
			if(Message::find($request->idMessage)) {
				return $next($request);
			} else { return redirect('/')->with('warning', "Ce message n'existe pas."); }
		} else { return redirect('/')->with('warning', "Ce forum n'existe pas."); }
    }
}
