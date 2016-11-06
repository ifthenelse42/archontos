<?php

namespace App\Repository\Sujet;

// Chargement de la base de donnée
use DB;
use Auth;

use App\Sujet;
use App\Forum;

class Epingle
{
	public function exec($id)
	{
		$id_forum = Sujet::find($id)->forum_id;

		DB::table('sujet')
		->where('id', $id)
		->update(['status' => 2]);

		return back()->with('success', "Le sujet est maintenant épinglé.");
	}

	public function unexec($id)
	{
		$id_forum = Sujet::find($id)->forum_id;

		DB::table('sujet')
		->where('id', $id)
		->update(['status' => 1]);

		return back()->with('success', "Le sujet n'est plus épinglé.");
	}
}
