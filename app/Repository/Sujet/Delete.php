<?php

namespace App\Repository\Sujet;

// Chargement de la base de donnée
use DB;
use Auth;

use App\Sujet;
use App\Forum;

class Delete
{
	public function exec($id)
	{
		$id_forum = Sujet::find($id)->forum_id;
		$titre_forum = Forum::find($id_forum)->titre;

		if(Sujet::find($id)->status > 0)
		{
			DB::table('sujet')
			->where('id', $id)
			->update(['status' => 0]); // On le rend invisible pour le commun des mortels

			return redirect('forum/'.$id_forum.'/'.str_slug($titre_forum, "-"));
		}

		else
		{
			DB::table('sujet')
			->where('id', $id)
			->update(['status' => 1]); // On le rend visible pour tous

			return redirect('forum/'.$id_forum.'/'.str_slug($titre_forum, "-"));
		}
	}
}
