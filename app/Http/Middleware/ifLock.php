<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

use App\Moderation;
use App\Message;
use App\Sujet;

use App\Repository\Moderation\isMod;

class ifLock
{


    public function handle($request, Closure $next)
    {
        $isMod = new isMod();
        
		if(Sujet::find($request->id)->ouvert == 1
		OR Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE
        OR $isMod->exec())
		{
			return $next($request);
		}

		return back()->with('error', "Ce sujet est verrouillé.");
    }
}
