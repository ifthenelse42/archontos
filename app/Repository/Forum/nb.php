<?php

namespace App\Repository\Forum;

// Chargement de la base de donnée
use DB;

use Auth;
use App\User;
use App\Message;

use App\Repository\Temps\Temps;

class Nb
{
	public function message($idForum)
	{
		$nb = DB::table('forum')
		->join('sujet', 'forum.id', '=', 'sujet.forum_id')
		->join('message', 'sujet.id', '=', 'message.sujet_id')
		->where('sujet.status', '<>', 0)
		->where('sujet.status', '<>', 0)
		->where('sujet.forum_id', $idForum)
		->count();

		if($nb > 1)
		{
			$string = $nb.' messages';
		}

		else
		{
			$string = $nb.' message';
		}

		return $string;
	}

	public function sujet($idForum)
	{
		$nb = DB::table('forum')
		->join('sujet', 'forum.id', '=', 'sujet.forum_id')
		->where('sujet.status', '<>', 0)
		->where('sujet.forum_id', $idForum)
		->count();

		return $nb;
	}
}
