<?php

namespace App\Repository\Utilisateurs\Compte;

// Chargement de la table Utilisateurs, important
use Auth;
use DB;
use Hash;

class Identifiant
{
	public function updateEmail($request)
	{
		$email = $request->input('email');

		DB::table('utilisateurs')
		->where('id', Auth::user()->id)
		->update(['email' => $email]);

		return back()->with('success', "Votre adresse email a bien été modifié.");
	}

	public function updatePassword($request)
	{
		$password = bcrypt($request->input('password'));

		DB::table('utilisateurs')
		->where('id', Auth::user()->id)
		->update(['password' => $password]);

		return back()->with('success', "Votre mot de passe a bien été modifié.");
	}
}
