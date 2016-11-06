<?php

namespace App\Repository\Utilisateurs;

// Chargement de la base de donnée
use DB;

use Carbon\Carbon;

use Auth;
use App\User;
use App\Sessions;
use App\Message;
use App\Sujet;

use App\Repository\Utilisateurs\Identificate;

class Liste
{
	// Variables des membres en ligne
	protected $minuteEnLigne = 10;
	protected $numberOut = 20;

	// Variables des membres actif
	protected $jourMembreActif = 30;

	public function online($id = 0, $location = 'index', $details = 1)
	{
		if($location == 'index') {
			$data = Sessions::where([
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
				['location', '<>', 'maintenance'],
				['utilisateurs_id', '>', 0],
				['invisible', 0],
			])
			->orderBy('updated_at', 'DESC')
			->get();

			$dataCount = Sessions::where([
				['utilisateurs_id', '>', 0],
				['location', '<>', 'maintenance'],
				['invisible', '=', 0],
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
			])
			->count();

			$countGuest = Sessions::where([
				['utilisateurs_id', '=', 0],
				['location', '<>', 'maintenance'],
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
			])
			->count();
		} elseif($location == 'sujet') { // si on est dans un sujet
			$data = Sessions::where([
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
				['location', 'sujet'],
				['location_id', $id],
				['utilisateurs_id', '>', 0],
				['invisible', 0],
			])
			->orderBy('updated_at', 'DESC')
			->get();

			$dataCount = Sessions::where([
				['utilisateurs_id', '>', 0],
				['location', 'sujet'],
				['location_id', $id],
				['invisible', '=', 0],
				['sessions.updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
			])
			->count();

			$countGuest = Sessions::where([
				['utilisateurs_id', '=', 0],
				['location', 'sujet'],
				['location_id', $id],
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
			])
			->count();
		} elseif($location == 'forum') { // si on est dans un forum
			$data = Sessions::where([
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
				['location', 'forum'],
				['location_id', $id],
				['utilisateurs_id', '>', 0],
				['invisible', 0],
			])
			->orderBy('updated_at', 'DESC')
			->get();

			$dataCount = Sessions::where([
				['utilisateurs_id', '>', 0],
				['location', 'forum'],
				['location_id', $id],
				['invisible', '=', 0],
				['sessions.updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
			])
			->count();

			$countGuest = Sessions::where([
				['utilisateurs_id', '=', 0],
				['location', 'forum'],
				['location_id', $id],
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
			])
			->count();
		}
		if($details == 1) {
			$identificate = new Identificate();
			$liste = '';
			$count = 1;

			foreach($data as $datas)
			{
				if($dataCount > 0 && $dataCount <= $this->numberOut)
				{
					if($count > 1 && $count != $dataCount OR $count == 1 && $dataCount > 1) //
					{
						$liste.= $identificate->pseudoWithLevel($datas->utilisateurs_id).', ';
					}

					else
					{
						$liste.= $identificate->pseudoWithLevel($datas->utilisateurs_id);
					}

				}

				elseif($dataCount >= $this->numberOut)
				{
					$liste = $dataCount.' membres connectés';
				}

				else
				{
					$liste.= $identificate->pseudoWithLevel($datas->utilisateurs_id);
				}

				$count++;
			}

			if($countGuest > 0 && $dataCount > 0)
			{
				if($countGuest > 1)
				{
					$liste .= ', et '.$countGuest.' visiteurs';
				}

				else
				{
					$liste .= ' et un visiteur';
				}
			}

			elseif($countGuest > 0)
			{
				if($countGuest > 1)
				{
					$liste .= $countGuest.' visiteurs';
				}

				else
				{
					$liste .= 'un visiteur';
				}
			}

			if($countGuest == 0 && $dataCount == 0) { $liste = "Il n'y a personne en ligne."; }
		} else {
			$countEx = $dataCount + $countGuest;

			if($countEx == 0) {
				$liste = "Il n'y a personne en ligne.";
			} elseif($countEx == 1) {
				$liste = $countEx.' connecté';
			} elseif($countEx > 1) {
				$liste = $countEx.' connectés';
			}
		}

		return $liste;
	}

	public function lastMembre()
	{
		$data = User::where('level', '>', 0)
			->orderBy('created_at', 'desc')
			->take(5)
			->get();

		return $data;
	}

	// fonction très importante à l'avenir qui servira en partie pour obtenir les membres actifs du forum
	public function membresActif()
	{
		// compte uniquement les messages actifs
		$data = User::join('message', 'utilisateurs.id', '=', 'message.utilisateurs_id')
			->join('sujet', 'sujet.id', '=', 'message.sujet_id')
			->where('message.created_at', '>', Carbon::now()->subDay($this->jourMembreActif))
			->where('message.status', '<>', 0)
			->where('sujet.status', '<>', 0)
			->where('utilisateurs.level', '>', 0)
			->select('utilisateurs.id as idMembre', 'utilisateurs.pseudo as pseudo', DB::raw('COUNT(message.id) AS count'))
			->groupBy('utilisateurs.id')
			->orderBy('count', 'desc')
			->orderBy('utilisateurs.pseudo', 'asc')
			->take(5)
			->get();

		return $data;
	}

	// retourne le nombre de messages créé dans le laps de temps par le membre actif
	public function countReturn($count)
	{
		if($count > 1)
		{
			return $count.' messages';
		}

		else
		{
			return 'un message';
		}
	}

	// Liste des sujets les plus populaires
	public function listLastSujet()
	{
		// NE FAIT AUCUNE DISTINCTION ADMIN/MEMBRE ET TYPE
		$data = Sujet::join('forum', 'sujet.forum_id', '=', 'forum.id')
			->join('forum_categorie', 'forum.categorie_id', '=', 'forum_categorie.id')
			->where('sujet.status', '>', 0)
			->where('sujet.ouvert', 1)
			->where('forum_categorie.type', 1)
			// doit ressembler à la fonction nbReponses::get()
			->select('sujet.id', 'sujet.utilisateurs_id', 'sujet.created_at', 'sujet.anonymous', 'sujet.titre as titre', 'forum.id as idForum')
			->take(10)
			->groupBy('sujet.id')
			->orderBy('sujet.created_at', 'desc')
			->get();

		return $data;
	}

	// Liste des derniers messages
	public function listLastMsg()
	{
		// NE FAIT AUCUNE DISTINCTION ADMIN/MEMBRE ET TYPE
		$data = Sujet::join('message', 'message.sujet_id', '=', 'sujet.id')
			->join('forum', 'sujet.forum_id', '=', 'forum.id')
			->join('forum_categorie', 'forum.categorie_id', '=', 'forum_categorie.id')
			->select('message.*', 'sujet.titre', 'forum.id as idForum', DB::raw('MAX(message.created_at) as last'))
			->where([
				['sujet.status', '>', 0],
				['message.status', '>', 0],
				['sujet.ouvert', 1],
				['forum_categorie.type', 1],
			])
			->groupBy('message.id', 'sujet.id')
			->orderBy('last', 'DESC')
			->take(10)
			->get();

		return $data;
	}
}
