<?php

namespace App\Repository\Mp;

// Chargement de la base de donnée
use DB;
use Auth;

use App\Mp_participants;

class Delete
{
	public function self($id_mp)
	{
		$mp_participants = new Mp_participants();

		$mp_participants
		->where('utilisateurs_id', Auth::user()->id)
		->where('id_mp', $id_mp)
		->delete();

		return redirect('mp')->with('success', "Vous avez bien quitté la conversation.");
	}

	public function all()
	{
		$mp_participants = new Mp_participants();

		$mp_participants
		->where('utilisateurs_id', Auth::user()->id)
		->delete();

		return back()->with('success', "Vous avez bien quitté toute les conversations.");
	}

	public function participant($id_mp, $idMembre)
	{
		$mp_participants = new Mp_participants();

		if($mp_participants->where('id_mp', $id_mp)->where('utilisateurs_id', $idMembre)->count() > 0)
		{
			$mp_participants
			->where('utilisateurs_id', $idMembre)
			->where('id_mp', $id_mp)
			->delete();

			return back()->with('success', "Le participant selectionné a bien été expulsé.");
		}

		return redirect('mp')->with('warning', "Le participant selectionné n'existe pas dans ce message privé.");
	}
}
