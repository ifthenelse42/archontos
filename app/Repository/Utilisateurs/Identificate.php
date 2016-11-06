<?php

namespace App\Repository\Utilisateurs;

// Chargement de la base de donnée
use DB;

use Carbon\Carbon;

use Auth;
use File;

use App\Moderation;
use App\User;
use App\Message;
use App\Sessions;

use App\Repository\Temps\Temps;

class Identificate
{
	// doit être identique à la même variable dans la classe Liste
	protected $minuteEnLigne = 10;

	public function pseudo($id)
	{
		$pseudo = User::find($id)->pseudo;

		return $pseudo;
	}

	public function id($pseudo)
	{
		$id = User::select('pseudo', 'id')->where('pseudo', $pseudo)->first()->id;

		return $id;
	}

	public function exist($id)
	{
		return User::select('id')->find($id)->count();
	}

	public function online($id) // retourne si le membre est en ligne ou non
	{
		$count = Sessions::where([
			['utilisateurs_id', $id],
			['location', '<>', 'maintenance'],
			['invisible', '=', 0],
			['sessions.updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
		])
		->groupBy('utilisateurs_id')
		->count();

		if($count > 0)
		{
			$enligne = '<span class="online-true">En ligne</span>';
		}

		else
		{
			$enligne = '<span class="online-false">Hors-ligne</span>';
		}

		return $enligne;
	}

	public function existByPseudo($pseudo)
	{
		return User::select('pseudo')->where('pseudo', $pseudo)->count();
	}

	/*
	>>>>>>> HIERARCHIE DES NIVEAUX D'ACCES <<<<<<<
	- NIVEAU 0 = NON VALIDE/BANNI
	- NIVEAU 1 = MEMBRE
	- NIVEAU 2 = MODERATEUR
	- NIVEAU 3 = ADMINISTRATEUR
	- NIVEAU 4 = WEBMASTER - IFTHENELSE
	*/

	public function pseudoWithLevel($id, $anonymous = 0, $forum = 0)
	{
		if($anonymous == 1 OR $anonymous == 1 && Auth::check() && Auth::user()->level < 3 && !session()->has('admins_unlock'))
		{
			return '<i>Anonyme</i>';
		}

		else
		{
			$pseudo = User::select('pseudo', 'id')->find($id)->pseudo;
			$level = User::select('level', 'id')->find($id)->level;

			if($forum == 0) {
				switch($level)
				{
					case 4:
						return '<a id="pseudo" href="'.url('membre/'.str_slug($pseudo,'-')).'" target="_blank"><span id="pseudo-webmaster">'.$pseudo.'</span></a>';
					break;

					case 3:
						return '<a id="pseudo" href="'.url('membre/'.str_slug($pseudo,'-')).'" target="_blank"><span id="pseudo-admin">'.$pseudo.'</span></a>';
					break;

					case 2:
						return '<a id="pseudo" href="'.url('membre/'.str_slug($pseudo,'-')).'" target="_blank"><span id="pseudo-membre">'.$pseudo.'</span></a>';
						//return '<span id="pseudo-moderateur">'.$pseudo.'</span>';
					break;

					case 1:
						return '<a id="pseudo" href="'.url('membre/'.str_slug($pseudo,'-')).'" target="_blank"><span id="pseudo-membre">'.$pseudo.'</span></a>';
					break;

					case 0:
						return '<span id="pseudo-ban">'.$pseudo.'</span>';
					break;

					default:
						return $pseudo;
				}
			} else {
				// effectuer la vérification de si le pseudo a un mandat actif dans ce forum
				if(Moderation::where([ // SI IL EST MODERATEUR ET AVEC UN MANDAT ACTIF
					['utilisateurs_id', $id],
					['forum_id', $forum],
					['mandat_debut', '<=', Carbon::now()],
					['mandat_fin', '>=', Carbon::now()],
				])->count() > 0 && User::find($id)->level == 2) {
					return '<span id="pseudo-moderateur">'.$pseudo.'</span>';
				}

				switch($level)
				{
					case 4:
						return '<a id="pseudo" href="'.url('membre/'.str_slug($pseudo,'-')).'" target="_blank"><span id="pseudo-webmaster">'.$pseudo.'</span></a>';
					break;

					case 3:
						return '<a id="pseudo" href="'.url('membre/'.str_slug($pseudo,'-')).'" target="_blank"><span id="pseudo-admin">'.$pseudo.'</span></a>';
					break;

					case 1:
						return '<a id="pseudo" href="'.url('membre/'.str_slug($pseudo,'-')).'" target="_blank"><span id="pseudo-membre">'.$pseudo.'</span></a>';
					break;

					case 0:
						return '<span id="pseudo-ban">'.$pseudo.'</span>';
					break;

					default:
						return $pseudo;
				}
			}
		}
	}

	public function anciennete($id)
	{
		$temps = new Temps();
		$date_create = User::select('created_at', 'id')->find($id)->created_at;

		return $temps->nbJours($date_create);
	}

	public function nbMessage($id)
	{
		// dois lier la table sujet pour également exclure les messages présent dans des sujets supprimés
		$nb = Message::join('sujet', 'sujet.id', '=', 'message.sujet_id')
		->select('message.utilisateurs_id', 'message.id', 'message.status', 'sujet.status')
		->where('message.utilisateurs_id', $id)
		->where('message.status', '<>', 0)
		->where('sujet.status', '<>', 0)
		->count();

		if($nb > 1)
		{
			return $nb.' messages';
		}

		else
		{
			return $nb.' message';
		}
	}

	public function level($id, $forum = 0)
	{
		$level = User::select('level', 'id')->find($id)->level;
		if($forum > 0) {
			if(Moderation::where([ // SI IL EST MODERATEUR ET AVEC UN MANDAT ACTIF
				['utilisateurs_id', $id],
				['forum_id', $forum],
				['mandat_debut', '<=', Carbon::now()],
				['mandat_fin', '>=', Carbon::now()],
			])->count() > 0 && User::find($id)->level == 2) {
				return 'Modérateur';
			}

			switch($level)
			{
				case 4:
					return 'Webmaster';
				break;

				case 3:
					return 'Administrateur';
				break;

				case 2:
					return 'Membre';
				break;

				case 1:
					return 'Membre';
				break;

				case 0:
					return 'Banni';
				break;

				default:
					return 'inconnu';
			}
		} else {
			switch($level)
			{
				case 4:
					return 'Webmaster';
				break;

				case 3:
					return 'Administrateur';
				break;

				case 2:
					return 'Modérateur';
				break;

				case 1:
					return 'Membre';
				break;

				case 0:
					return 'Banni';
				break;

				default:
					return 'inconnu';
			}
		}
	}

	public function getLevel($id)
	{
		return User::select('level', 'id')->find($id)->level;
	}

	public function presentation($id)
	{
		return User::select('presentation', 'id')->find($id)->presentation;
	}

	public function activity($id)
	{
		return User::select('activity', 'id')->find($id)->activity;
	}

	public function avatar($id, $anonymous = 0)
	{
		// si le champs "avatar" n'est pas vide et si le fichier existe alors on affiche l'avatar
		if(!empty(User::select('avatar', 'id')->find($id)->avatar) && file_exists(public_path('avatars/'.$id.'.png')) && $anonymous == 0)
		{
			return asset('avatars/'.$id.'.png');
		}
		// sinon on retourn l'image par défaut
		else
		{
			return asset('avatars/noavatar.jpg');
		}
	}

	public function email($id)
	{
		return User::select('email', 'id')->find($id)->email;
	}

	public function invisible($id)
	{
		return User::select('invisible', 'id')->find($id)->invisible;
	}

	public function anonymous($id)
	{
		return User::select('anonymous', 'id')->find($id)->anonymous;
	}
}
