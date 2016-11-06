<?php

namespace App\Repository\Message;

// Chargement de la base de donnée
use DB;

// Ce répertoire sert à obtenir les numéros des messages par rapport au sujet.
class Number
{
	public function get($idSujet)
	{
		$message = DB::table('message')
		->join('sujet', 'sujet.id', '=', 'message.sujet_id')
		->select(DB::raw('count(message.id) as numero'))
		->where('sujet.id', $idSujet)
		->count();

		return $message;
	}

	public function actual($idSujet, $idMessage)
	{
		$message = DB::table('message')
		->join('sujet', 'sujet.id', '=', 'message.sujet_id')
		->select(DB::raw('count(message.id) as numero'))
		->where('sujet.id', $idSujet);
	}
}
