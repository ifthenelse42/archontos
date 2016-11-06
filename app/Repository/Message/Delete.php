<?php

namespace App\Repository\Message;

// Chargement de la base de donnée
use DB;
use Auth;
use Request;
use App\Sujet;
use App\Message;

use App\Http\Controllers\SujetController;

class Delete
{
	public function exec($id)
	{
		$id_sujet = Message::find($id)->sujet_id;
		$titre_sujet = Sujet::find($id_sujet)->titre;

		// Si l'id du message à supprimer est égal au premier message du sujet alors on supprime le sujet.
		// Ca n'est pas nécessaire mais on le laisse au cas ou, car le bouton pour supprimer le premier message n'apparait pas.
		if($id == Message::where('sujet_id', $id_sujet)->orderBy('created_at', 'ASC')->first()->id)
		{
			$sujet = new SujetController;
			return $sujet->destroy($id_sujet); // On supprime le sujet.
		}

		// Sinon, on supprime le message normalement.
		else
		{
			if(Message::find($id)->status > 0)
			{
				DB::table('message')
				->where('id', $id)
				->update(['status' => 0]); // On le rend invisible pour le commun des mortels
				return redirect('sujet/'.$id_sujet.'/'.str_slug($titre_sujet, "-"));
			}

			else
			{
				DB::table('message')
				->where('id', $id)
				->update(['status' => 1]); // On le rend visible pour tous
				return redirect('sujet/'.$id_sujet.'/'.str_slug($titre_sujet, "-"));
			}
		}
	}
}
