<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use App\Forum;
use App\Sujet;

class Banni
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
		$sujet = new Sujet;
		$forum = new Forum;
		/*
		// Si le membre est banni
		if(Auth::check() && Auth::user()->level == 0 && $request->isMethod('post'))
		{
			// Si là où il poste est un forum pour les bannis
			$id = $request->id;
			$lieu = $request->segment(1);

			if($lieu == 'forum') {
				if($forum->find($id)->categorie->type == 0) {
					return $next($request);
				}
			} elseif($lieu == 'sujet') {
				if($sujet->find($id)->forum->categorie->type == 0) {
					return $next($request);
				}
			} elseif($lieu == 'compte') { // on les autorise à modifier leur compte quand même
					return $next($request);
			}

			return back()->with('error', "Vous ne pouvez pas faire cela car vous êtes banni, vous ne pouvez intéragir que dans un forum vous étant dédié.");
		}*/

		if(Auth::check() && Auth::user()->level == 0) {
			session()->flush();
			Auth::logout();

			return redirect('http://rickrolled.fr/');
		}
        return $next($request);
    }
}
