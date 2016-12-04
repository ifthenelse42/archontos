<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use App\Forum;
use App\Sujet;
use App\Message;

class forumType
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
		$id = $request->id;
		$forum = new Forum;
		$sujet = new Sujet;
		$message = new Message;

		if($request->segment(1) == 'forum') // si c'est un forum
		{
			if($forum->find($id)->categorie->type == 3) // si c'est une catégorie de la modération
			{
				if(Auth::check() && Auth::user()->level > 2 OR Auth::check() && Auth::user()->level == 2 && session()->has('moderation_unlock'))
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			elseif($forum->find($id)->categorie->type == 2) // si c'est une catégorie pour les membres connectés
			{
				if(Auth::check() && Auth::user()->level > 0) // si il est en ligne et pas banni
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			elseif($forum->find($id)->categorie->type == 0) // si c'est une catégorie pour les bannis (exilés)
			{
				if(Auth::check() && Auth::user()->level == 0 OR Auth::check() && Auth::user()->level > 1) // si il est banni ou est plus que membre
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum."); // le problème de l'upgrade 5.3 viens d'ici
				}
			}

			else
			{
                return $next($request);
			}
		}

		elseif($request->segment(1) == 'sujet')
		{
			if($sujet->find($id)->forum->categorie->type == 3) // si c'est une catégorie de la modération
			{
				if(Auth::check() && Auth::user()->level > 2 OR Auth::check() && Auth::user()->level == 2 && session()->has('moderation_unlock'))
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			elseif($sujet->find($id)->forum->categorie->type == 2) // si c'est une catégorie pour les membres connectés
			{
				if(Auth::check() && Auth::user()->level > 0) // si il est en ligne et pas banni
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			elseif($sujet->find($id)->forum->categorie->type == 0) // si c'est une catégorie pour les bannis (exilés)
			{
				if(Auth::check() && Auth::user()->level == 0 OR Auth::check() && Auth::user()->level > 1) // si il est banni ou est plus que membre
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			else
			{
				return $next($request); // on s'en fou alors on continue
			}
		}

		elseif($request->segment(1) == 'message')
		{
			if($message->find($id)->sujet->forum->categorie->type == 3) // si c'est une catégorie de la modération
			{
				if(Auth::check() && Auth::user()->level > 2 OR Auth::check() && Auth::user()->level == 2 && session()->has('moderation_unlock'))
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			elseif($message->find($id)->sujet->forum->categorie->type == 2) // si c'est une catégorie pour les membres connectés
			{
				if(Auth::check() && Auth::user()->level > 0) // si il est en ligne et pas banni
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			elseif($message->find($id)->sujet->forum->categorie->type == 0) // si c'est une catégorie pour les bannis (exilés)
			{
				if(Auth::check() && Auth::user()->level == 0 OR Auth::check() && Auth::user()->level > 1) // si il est banni ou est plus que membre
				{
					return $next($request); // on continue
				}

				else
				{
					return redirect('/')->with('error', "Vous ne pouvez pas accéder à ce forum.");
				}
			}

			else
			{
				return $next($request); // on s'en fou alors on continue
			}
    	}

		else
		{
			return $next($request); // on s'en fou alors on continue
		}
	}
}
