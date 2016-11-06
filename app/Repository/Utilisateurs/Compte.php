<?php

namespace App\Repository\Utilisateurs;

// Chargement de la table Utilisateurs, important
use Auth;
use DB;
use Hash;

use Intervention\Image\Facades\Image as Image;

use App\User;

class Compte
{
	public function updateAvatar($request)
	{
		if($request->hasFile('avatar'))
		{
			if($request->file('avatar')->isValid())
			{
				$file = $request->file('avatar');
				$location = public_path().'/avatars/';
				$avatar = $location.Auth::user()->id.'.png';
				$avatar_image = $request->file('avatar')->move($location, $avatar);

				// Redimensionnement de l'image et ajout dans le dossier
				Image::make($avatar)->resize(240, 240)->save($avatar);


				DB::table('utilisateurs')
				->where('id', Auth::user()->id)
				->update(['avatar' => $avatar]);

				return back()->with('success', "Votre avatar a bien été modifié.");
			}

			return back()->with('warning', "L'envoi de l'avatar a échoué.");
		}

		return back();

	}

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
		$password = $request->input('password');
		$password_old = $request->input('password_old');

		// Si le mot de passe actuel est bel et bien l'actuel.
		if(Hash::check($password_old, User::find(Auth::user()->id)->password))
		{
			if(Hash::check($password, User::find(Auth::user()->id)->password))
			{
				return back()->with('warning', "Votre nouveau mot de passe doit différer de l'ancien.");
			}

			DB::table('utilisateurs')
			->where('id', Auth::user()->id)
			->update(['password' => bcrypt($password)]);

			return back()->with('success', "Votre mot de passe a bien été modifié.");
		}

		else
		{
			return back()->with('warning', "Le mot de passe actuel est incorrect.");
		}
	}

	public function updateOptions($request)
	{
		$utilisateurs = new User();
		$date = \Carbon\Carbon::now();

		$invisible = $request->input('invisible');
		$anonymous = $request->input('anonymous');

		// on met à jour selon si les valeurs sont cochées ou non
		if(!empty($invisible))
		{
			$utilisateurs->where('id', Auth::user()->id)
			->update([
				'invisible' => 1,
				'updated_at' => $date
			]);
		}

		else // si ce n'est pas coché, on désactive l'invisibilité
		{
			$utilisateurs->where('id', Auth::user()->id)
			->update([
				'invisible' => 0,
				'updated_at' => $date
			]);
		}

		if(!empty($anonymous))
		{
			$utilisateurs->where('id', Auth::user()->id)
			->update([
				'anonymous' => 1,
				'updated_at' => $date
			]);
		}

		else
		{
			$utilisateurs->where('id', Auth::user()->id)
			->update([
				'anonymous' => 0,
				'updated_at' => $date
			]);
		}

		return back()->with('success', "Vos options ont bien été mises à jour.");
	}

	public function updateProfil($request)
	{
		$utilisateurs = new User();
		$date = \Carbon\Carbon::now();

		$presentation = $request->input('presentation');

		if(empty($request->input('activity'))) {
			$activity = 0;
		} else {
			$activity = 1;
		}

		// on met à jour selon si les valeurs sont remplies ou non
		if(!empty($presentation))
		{
			$utilisateurs->where('id', Auth::user()->id)
			->update([
				'presentation' => $presentation,
				'updated_at' => $date
			]);
		}

		if($activity == 1 OR $activity == 0)
		{
			$utilisateurs->where('id', Auth::user()->id)
			->update([
				'activity' => $activity,
				'updated_at' => $date
			]);
		}

		return back()->with('success', "Votre profil a bien été mise à jour.");
	}
}
