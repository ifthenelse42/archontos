<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use Carbon\Carbon;

use App\Exclusion;
use App\Forum;
use App\Sujet;
use App\Message;

class ExclusionHandle
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
		$url = $request->segment(1);

		if(Auth::check()) {
			if(Exclusion::where([
				['utilisateurs_id', '>', 0],
				['utilisateurs_id', Auth::user()->id],
				['remain', '>', Carbon::now()],
				['type', '=', 3], // si son compte est verrouillé
			])->count() == 0 OR $url == 'exclu') {
				if($url == 'forum' && isset($request->id) && Exclusion::where([
					['utilisateurs_id', '>', 0],
					['utilisateurs_id', Auth::user()->id],
					['forum_id', $request->id],
					['remain', '>', Carbon::now()],
					])->count() > 0 && $request->isMethod('post')) { // si on est dans un forum, qu'on est exclu et qu'on essaye de poster dedans dedans
					return back()->with('error', "Vous êtes exclu de ce forum et ne pouvez pas y poster.");
				} elseif($url == 'sujet' && Exclusion::where([
					['utilisateurs_id', '>', 0],
					['utilisateurs_id', Auth::user()->id],
					['forum_id', Sujet::find($request->id)->forum->id],
					['remain', '>', Carbon::now()],
					])->count() > 0 && $request->isMethod('post')) { // si on est dans un forum, qu'on est exclu et qu'on essaye de poster dedans
					return back()->with('error', "Vous êtes exclu de ce forum et ne pouvez pas y poster.");
				}  elseif(Exclusion::where([
					['utilisateurs_id', '>', 0],
					['utilisateurs_id', Auth::user()->id],
					['forum_id', 0],
					['remain', '>', Carbon::now()],
					])->count() > 0 && $request->isMethod('post') && $url != 'mp' && $url != 'compte') { // exclusion globale
					return back()->with('error', "Vous êtes exclu de tous les forums.");
				} else { return $next($request); } // sinon s'il n'est pas exclu on continue

			} else {
				session()->flush();
				Auth::logout();
				return redirect('exclu');
			}
		}
		return $next($request);
    }
}
