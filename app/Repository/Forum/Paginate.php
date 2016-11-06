<?php

namespace App\Repository\Forum;

// Chargement de la base de donnée
use DB;

use Auth;

class Paginate
{
	protected $paginateNb = 30;

	public function requestSujet($message, $id)
	{
		if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE) // si c'est au moins un admin
		{
			return $message
			->where('sujet_id', $id)
			->orderBy('created_at', 'ASC')
			->paginate($this->paginateNb);
		}

		else // si c'est pas au moins un admin
		{
			return $message
			->where('sujet_id', $id)
			->where('status', 1)
			->orderBy('created_at', 'ASC')
			->paginate($this->paginateNb);
		}
	}

	public function requestSujetListe($sujet, $id)
	{
		if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE) // si c'est au moins un admin
		{
			return $sujet
			->join('message', 'message.sujet_id', '=', 'sujet.id')
			->select('sujet.*', DB::raw('MAX(message.created_at) as last'))
			->where('sujet.forum_id', $id)
			->groupBy('sujet.id')
			->orderBy('sujet.status', 'DESC')
			->orderBy('last', 'DESC')
			->paginate($this->paginateNb);
		}

		else // si c'est pas au moins un admin
		{
			return $sujet
			->join('message', 'message.sujet_id', '=', 'sujet.id')
			->select('sujet.*', DB::raw('MAX(message.created_at) as last'))
			->where('sujet.forum_id', $id)
			->where('sujet.status', '>', 0) // n'est pas présent pour les administrateurs, pour voir les messages/sujets supprimés
			->groupBy('sujet.id')
			->orderBy('sujet.status', 'DESC')
			->orderBy('last', 'DESC')
			->paginate($this->paginateNb);
		}
	}

	public function requestMp($mp, $id)
	{
		return $mp
		->join('mps_sujets', 'mps_sujets.id', '=', 'mps.id_mp')
		->join('mps_participants', 'mps_participants.id_mp', '=', 'mps_sujets.id')
		->select('mps.*')
		->where('mps_sujets.status', 1)
		->where('mps_participants.utilisateurs_id', Auth::user()->id)
		->where('mps_sujets.id', $id)
		->groupBy('mps.id')
		->orderBy('mps.created_at', 'DESC')
		->paginate($this->paginateNb);
	}

	public function requestMpListe($mp_sujet)
	{
		return $mp_sujet
		->join('mps_participants', 'mps_participants.id_mp', '=', 'mps_sujets.id')
		->join('mps', 'mps.id_mp', '=', 'mps_sujets.id')
		->select('mps_sujets.*', DB::raw('MAX(mps.created_at) as last'))
		->where('mps_sujets.status', 1)
		->where('mps_participants.utilisateurs_id', Auth::user()->id)
		->groupBy('mps_sujets.id')
		->orderBy('last', 'DESC')
		->paginate($this->paginateNb);
	}
}
