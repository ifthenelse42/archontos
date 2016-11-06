<?php

namespace App\Repository\Sujet;

// Chargement de la base de donnée
use DB;
use Auth;

use App\Sujet;
use App\Forum;

class Verrouille
{
	public function exec($id)
	{
		$id_forum = Sujet::find($id)->forum_id;

		DB::table('sujet')
		->where('id', $id)
		->update(['ouvert' => 0]);

		return back()->with('success', "Le sujet est maintenant verrouillé.");
	}

	public function unexec($id)
	{
		$id_forum = Sujet::find($id)->forum_id;

		DB::table('sujet')
		->where('id', $id)
		->update(['ouvert' => 1]);

		return back()->with('success', "Le sujet n'est plus verrouillé.");
	}
}
