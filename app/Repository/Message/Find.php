<?php

namespace App\Repository\Message;

use Auth;
use DB;
use App\Message;
use App\Sujet;
use App\Mp;
use App\Mp_sujet;

class Find
{
	// Variables globale dans la classe, à partager avec SujetController
	protected $perPage = 30;

	public function url($id, $location = 'sujet', $formulaire = 0) // renvoi l'url de la localisation exacte du message
	{
		if($location == 'sujet')
		{
			$idSujet = Message::find($id)->sujet_id;
			$titreSujet = Sujet::find($idSujet)->titre;

			if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
			{
				$count = Message::select(DB::raw('COUNT(*) as nb'))
				->where('sujet_id', $idSujet)
				->where('id', '<', $id)
				->first()->nb;

				$total = Message::where('sujet_id', $idSujet)
				->count();
			}

			else
			{
				$count = Message::select(DB::raw('COUNT(*) as nb'))
				->where('sujet_id', $idSujet)
				->where('status', 1)
				->where('id', '<', $id)
				->first()->nb;

				$total = Message::where('sujet_id', $idSujet)
				->where('status', 1)
				->count();
			}

			$nbPage = ceil($total / $this->perPage);
			$page = floor($count / $this->perPage + 1);
			if($formulaire == 1) {
				if($page > 1) {
					$url = url('sujet/'.$idSujet.'/'.str_slug($titreSujet, '-').'?page='.$page.'#formulaire');
				} else {
					$url = url('sujet/'.$idSujet.'/'.str_slug($titreSujet, '-').'#formulaire');
				}
			} else {
				if($page > 1) {
					$url = url('sujet/'.$idSujet.'/'.str_slug($titreSujet, '-').'?page='.$page.'#message_'.Find::number($id));
				} else {
					$url = url('sujet/'.$idSujet.'/'.str_slug($titreSujet, '-').'#message_'.Find::number($id));
				}
			}

		}

		elseif($location == 'mp')
		{
			/*
			à cause du changement de sens de l'affichage des mps, on n'en a plus besoin.
			$id_mp = Mp::find($id)->id_mp;
			$titreMp = Mp_sujet::find($id_mp)->titre;

			if(Auth::check() && Auth::user()->level > 2)
			{
				$count = Mp::select(DB::raw('COUNT(*) as nb'))
				->where('id_mp', $id_mp)
				->where('id', '<', $id)
				->first()->nb;

				$total = Mp::where('id_mp', $id_mp)
				->count();
			}

			else
			{
				$count = Mp::select(DB::raw('COUNT(*) as nb'))
				->where('id_mp', $id_mp)
				->where('status', 1)
				->where('id', '<', $id)
				->first()->nb;

				$total = Mp::where('id_mp', $id_mp)
				->where('status', 1)
				->count();
			}

			$nbPage = ceil($total / $this->perPage);
			$page = floor($count / $this->perPage + 1);

			if($page > 1)
			{
				$url = url('mp/'.$id_mp.'/'.str_slug($titreMp, '-').'?page='.$page);
			}

			else
			{
				$url = url('mp/'.$id_mp.'/'.str_slug($titreMp, '-'));
			}*/

			$id_mp = Mp::find($id)->id_mp;
			$titreMp = Mp_sujet::find($id_mp)->titre;

			$url = url('mp/'.$id_mp.'/'.str_slug($titreMp, '-'));
		}

		return $url;
	}

	public function number($id, $location = 'sujet') // renvoi le nombre du message par rapport au sujet
	{
		if($location == 'sujet')
		{
			$idSujet = Message::find($id)->sujet_id;
			if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
			{
				$nb = Message::select(DB::raw('COUNT(*) as nb'))
				->where('sujet_id', $idSujet)
				->where('id', '<', $id)
				->first()->nb;
			}

			else
			{
				$nb = Message::select(DB::raw('COUNT(*) as nb'))
				->where('sujet_id', $idSujet)
				->where('id', '<', $id)
				->where('status', 1)
				->first()->nb;
			}
		}

		elseif($location == 'mp')
		{
			$id_mp = Mp::find($id)->id_mp;
			if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
			{
				$nb = Mp::select(DB::raw('COUNT(*) as nb'))
				->where('id_mp', $id_mp)
				->where('id', '<', $id)
				->first()->nb;
			}

			else
			{
				$nb = Mp::select(DB::raw('COUNT(*) as nb'))
				->where('id_mp', $id_mp)
				->where('id', '<', $id)
				->where('status', 1)
				->first()->nb;
			}
		}

		return $nb + 1;
	}
}
