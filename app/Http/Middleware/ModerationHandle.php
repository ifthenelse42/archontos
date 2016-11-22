<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use Carbon\Carbon;

use App\Moderation;
use App\Sujet;
use App\Message;
use App\User;

class ModerationHandle
{
    public function handle($request, Closure $next)
    {
		if(Auth::check() && Auth::user()->level == 2) {
			if(Moderation::where([ // SI IL EST MODERATEUR ET AVEC UN MANDAT ACTIF
				['utilisateurs_id', Auth::user()->id],
				['mandat_debut', '<=', Carbon::now()],
				['mandat_fin', '>=', Carbon::now()],
			])->count() > 0) {
				return $next($request);
			} else {
                User::where('id', Auth::user()->id)->update([ // s'il n'est plus modérateur
				'level' => 1
			    ]);
                return redirect('/')->with('error', "Vous ne possédez plus de mandat actif. Vos droits spécifique à la modération ont donc disparus.");
			    session()->flush();
            }
		}

        return $next($request);
    }
}
