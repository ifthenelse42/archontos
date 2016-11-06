<?php

namespace App\Repository\Sujet;

// Chargement de la base de donnée
use DB;
use App\Message;

class LastMsg
{
	public function get($idSujet)
	{
		return Message::where('sujet_id', $idSujet)
		->orderBy('created_at', 'DESC')
		->first();
	}

	public function firstGet($idSujet) // pour les popovers
	{
		return Message::where('sujet_id', $idSujet)
		->orderBy('created_at', 'ASC')
		->first();
	}

	public function lastGet($idSujet) // pour les popovers
	{
		return Message::where('sujet_id', $idSujet)
		->orderBy('created_at', 'DESC')
		->first();
	}
}
