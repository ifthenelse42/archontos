<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use App\Sujet;
use App\Message;
use App\Forum;
use App\Mp;
use App\Mp_sujet;

use App\Repository\Forum\Paginate;

class ifExist
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
		$location1 = $request->segment(1);
		$location2 = $request->segment(2);

		if($location1 == 'sujet') // dans un sujet, il n'est pas nécessaire de préciser que le second segment existe
		{
			if(Sujet::find($request->id)->status > 0 OR Sujet::find($request->id) && Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE) // si le sujet existe
			{
				$paginate = new Paginate();
				$message = new Message();

				$pagination = $paginate->requestSujet($message, $request->id);

				if($pagination->lastPage() >= 1 && $pagination->currentPage() > $pagination->lastPage())
				{
					return redirect('/')->with('error', "Cette page n'existe pas.");
				}

				return $next($request);
			}

			else
			{
				return redirect('/')->with('error', "Ce sujet n'existe pas.");
			}
		}

		elseif($location1 == 'forum' && is_numeric($location2)) // liste des sujets
		{
			if(Forum::find($request->id))
			{
				$paginate = new Paginate();
				$sujet = new Sujet();

				$pagination = $paginate->requestSujetListe($sujet, $request->id);

				if($pagination->lastPage() >= 1 && $pagination->currentPage() > $pagination->lastPage())
				{
					return redirect('/')->with('error', "Cette page n'existe pas.");
				}

				return $next($request);
			}

			else
			{
				return redirect('/')->with('error', "Ce forum n'existe pas.");
			}
		}

		elseif($location1 == 'mp' && is_numeric($location2)) // dans un mp
		{
			if(Mp::find($request->id)->status > 0)
			{
				$paginate = new Paginate();
				$mp = new Mp();

				$pagination = $paginate->requestMp($mp, $request->id);

				if($pagination->lastPage() >= 1 && $pagination->currentPage() > $pagination->lastPage())
				{
					return redirect('/')->with('error', "Cette page n'existe pas.");
				}

				return $next($request);
			}

			else
			{
				return redirect('/')->with('error', "Ce message privé n'existe pas.");
			}
		}

		elseif($location1 == 'mp' && empty($location2)) // liste des mps
		{
			$paginate = new Paginate();
			$mp_sujet = new Mp_sujet();

			$pagination = $paginate->requestMpListe($mp_sujet);

			if($pagination->lastPage() >= 1 && $pagination->currentPage() > $pagination->lastPage())
			{
				return redirect('/')->with('error', "Cette page n'existe pas.");
			}

			return $next($request);
		}

		return $next($request);
    }
}
