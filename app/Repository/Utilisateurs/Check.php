<?php

namespace App\Repository\Utilisateurs;

// Chargement de la table Utilisateurs, important
use Auth;

class Check
{
	public function validate($request)
	{
		if($request->input('stay') == 1)
		{
			$stay = true;
		}

		else
		{
			$stay = false;
		}

		if(Auth::attempt(['pseudo' => $request->input('pseudo'), 'password' => $request->input('password')], $stay))
		{
			return redirect('/');
		}
	}
}
