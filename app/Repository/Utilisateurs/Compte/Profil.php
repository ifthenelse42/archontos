<?php

namespace App\Repository\Utilisateurs\Compte;

// Chargement de la table Utilisateurs, important
use Auth;
use DB;

class Profil
{
	public function updateAvatar($request)
	{
		$avatar = $request->input('avatar');

		DB::table('utilisateurs')
		->where('id', Auth::user()->id)
		->update(['avatar' => $avatar]);

		return back()->with('success', "Votre avatar a bien été modifié.");
	}
}
