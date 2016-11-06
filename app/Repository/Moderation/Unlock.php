<?php

namespace App\Repository\Moderation;

// Chargement de la base de donnée
use DB;
use Auth;
use Hash;

use App\User;
use App\Moderation;

class Unlock
{
	public function exec($request)
	{
		if(Moderation::where('utilisateurs_id', Auth::user()->id)->count() > 0)
		{
			$password = $request->input('password');
			$key = $request->input('secret_password');

			$passwordMembre = User::find(Auth::user()->id)->password;
			$keyMembre = Moderation::where('utilisateurs_id', Auth::user()->id)->first()->secret_password;

			if(Hash::check($password, $passwordMembre))
			{
				if(Hash::check($key, $keyMembre))
				{
					session()->put('moderation_unlock', TRUE);

					return redirect('/')->with('success', "Vos droits ont bien été déverrouillés.");
				}

				else
				{
					return back()->with('warning', "Votre clé de déverrouillage est invalide.");
				}
			}

			else
			{
				return back()->with('warning', "Votre mot de passe est incorrect.");
			}
		}

		else
		{
			return back()->with('warning', "Vous ne figurez pas dans la liste des modérateurs.");
		}
	}
}
