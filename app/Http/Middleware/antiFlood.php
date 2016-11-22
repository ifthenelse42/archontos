<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

use App\Message;
use App\Mp;

use Carbon\Carbon;

// PROTECTION ANTI FLOOD \\
class antiFlood
{
	protected $secondBtwPosts = 2; // le nombre de seconde entre chaque messages

	// si il est banni, le nb de seconde entre chaque messages augmente grandement
	public function __construct() {
		if(Auth::user()->level == 0) {
			$this->secondBtwPosts = 600;
		}
	}


    public function handle($request, Closure $next)
    {
		$idPseudo = Auth::user()->id;

		if($request->segment(1) == 'mp')
		{
			if(Mp::where('utilisateurs_id', $idPseudo)->count() > 0) // Si l'utilisateur a déjà créé au moins un message
			{
				// On récupère le dernier message posté par soit-même
				$idMp = Mp::
				where('utilisateurs_id', $idPseudo)
				->orderBy('created_at', 'desc')
				->first()
				->id;

				$dateLastMsg = Mp::
				where('utilisateurs_id', $idPseudo)
				->find($idMp)
				->orderBy('created_at', 'desc')
				->first()
				->created_at;

				$dateDiff = Carbon::createFromFormat('Y-m-d H:i:s', $dateLastMsg);

				$secondesDiff = $dateDiff->diffInSeconds(Carbon::now());

				if($secondesDiff <= $this->secondBtwPosts)
				{
					return back()
					->with('error', "Vous ne pouvez envoyer un message qu'une fois toute les ".$this->secondBtwPosts." secondes.")
					->withInput();
				}
			}

			return $next($request);
		}

		else // si ça n'est pas un mp, c'est forcément un sujet ou message
		{
			if(Message::where('utilisateurs_id', $idPseudo)->count() > 0) // Si l'utilisateur a déjà créé au moins un message
			{
				// On récupère le dernier message posté par soit-même
				$idMessage = Message::
				where('utilisateurs_id', $idPseudo)
				->orderBy('created_at', 'desc')
				->first()
				->id;

				$dateLastMsg = Message::
				where('utilisateurs_id', $idPseudo)
				->find($idMessage)
				->orderBy('created_at', 'desc')
				->first()
				->created_at;

				$dateDiff = Carbon::createFromFormat('Y-m-d H:i:s', $dateLastMsg);

				$secondesDiff = $dateDiff->diffInSeconds(Carbon::now());

				if($secondesDiff <= $this->secondBtwPosts)
				{
					return back()
					->with('error', "Vous ne pouvez envoyer un message qu'une fois toute les ".$this->secondBtwPosts." secondes.")
					->withInput();
				}
			}

			return $next($request);
		}
    }
}
