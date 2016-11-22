<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use Carbon\Carbon;

use App\Moderation;
use App\Forum;
use App\Sujet;
use App\Message;

class ModerationCheck
{
    /* utilisé dans les fonctions de modération */
    public function handle($request, Closure $next)
    {
		$url1 = $request->segment(1);
		$url2 = $request->segment(2);
		$id = $request->id;

		if($url1 == 'forum') { // si il est sur un forum
			if(Moderation::where([ // si il est modérateur du forum où le sujet est, et si son mandat a débuté et n'a pas fini
				['utilisateurs_id', Auth::user()->id],
				['forum_id', $id],
				['mandat_debut', '<=', Carbon::now()],
				['mandat_fin', '>=', Carbon::now()],
			])->count() == 1) {
				return $next($request);
			}

			return redirect('/')->with('error', "Vous ne modérez pas ce forum.");
		} elseif($url1 == 'sujet') { // si il est dans un sujet
			if(Moderation::where([ // si il est modérateur du forum où le sujet est, et si son mandat a débuté et n'a pas fini
				['utilisateurs_id', Auth::user()->id],
				['forum_id', Sujet::find($id)->forum->id],
				['mandat_debut', '<=', Carbon::now()],
				['mandat_fin', '>=', Carbon::now()],
			])->count() == 1) {
				return $next($request);
			}

			return redirect('/')->with('error', "Vous ne modérez pas ce forum.");
		} elseif($url1 == 'message') { // si il est dans un message
			if(Moderation::where([ // si il est modérateur du forum où le message est, et si son mandat a débuté et n'a pas fini
				['utilisateurs_id', Auth::user()->id],
				['forum_id', Message::find($id)->sujet->forum->id],
				['mandat_debut', '<=', Carbon::now()],
				['mandat_fin', '>=', Carbon::now()],
			])->count() == 1) {
				return $next($request);
			}

			return redirect('/')->with('error', "Vous ne modérez pas ce forum.");
		} elseif($url1 == 'moderation' && $url2 == 'exclusion') { // si il est dans un formulaire d'exclusion
			if(Forum::find($request->idForum)) {
				if(Moderation::where([ // si il est modérateur du forum où le message est, et si son mandat a débuté et n'a pas fini
					['utilisateurs_id', Auth::user()->id],
					['forum_id', Message::find($request->idForum)->id],
					['mandat_debut', '<=', Carbon::now()],
					['mandat_fin', '>=', Carbon::now()],
				])->count() == 1) {
					return $next($request);
				}
			}

			return redirect('/')->with('error', "Vous ne modérez pas ce forum.");
		}
        return $next($request);
    }
}
