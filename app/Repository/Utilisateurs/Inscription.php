<?php

namespace App\Repository\Utilisateurs;

// Chargement de la base de donnée
use DB;
use App\User;

class Inscription
{
	public function save($request)
	{
		if(User::where('ip', \app\Http\Helperfunctions::getIp())->count() == 0)
		{
			$pseudo = $request->input('pseudo');
			$email = $request->input('email');
			$password = bcrypt($request->input('password'));

			$remember_token = '';
			$created_at = \Carbon\Carbon::now();
			$updated_at = \Carbon\Carbon::now();

			DB::table('utilisateurs')->insert([
				'pseudo' => $pseudo,
				'email' => $email,
				'password' => $password,
				'level' => 1,
				'avatar' => '',
				'presentation' => '',
				'activity' => 1,
				'invisible' => 0,
				'anonymous' => 0,
				'ip' => \app\Http\Helperfunctions::getIp(),
				'remember_token' => $remember_token,
				'created_at' => $created_at,
				'updated_at' => $updated_at
			]);

			return redirect('/')->with('success', "
			Votre compte a été enregistré. Vos identifiants sont les suivants :<br />
			Pseudo : ".e($pseudo)."<br />
			Adresse email : ".e($email)."<br />
			Mot de passe : ".e($request->input('password'))."<br />
			<br />
			Vous pouvez d'ores et déjà vous connecter à l'aide de votre pseudo et mot de passe.
			");
		}

		else
		{
			return back()->with('error', "Vous êtes déjà inscris.");
		}
	}
}
