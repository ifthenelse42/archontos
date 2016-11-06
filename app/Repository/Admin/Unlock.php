<?php

namespace App\Repository\Admin;

// Chargement de la base de donnée
use DB;
use Auth;
use Hash;

use App\User;
use App\Admin;

class Unlock
{
	public function poste($request)
	{
		if(Admin::where('utilisateurs_id', Auth::user()->id)->count() > 0)
		{
			$password = $request->input('password');
			$key = $request->input('secret_password');

			$passwordMembre = User::find(Auth::user()->id)->password;
			$keyMembre = Admin::where('utilisateurs_id', Auth::user()->id)->first()->secret_password;

			if(Hash::check($password, $passwordMembre))
			{
				if(Hash::check($key, $keyMembre))
				{
					session()->put('admins_unlock', TRUE);

					return redirect('admin')->with('success', "Vos droits ont bien été déverrouillés.");
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
			return back()->with('warning', "Vous ne figurez pas dans la liste des administrateurs.");
		}
	}
}
