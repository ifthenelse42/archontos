<?php

namespace App\Repository\Admin;

// Chargement de la base de donnée
use DB;
use Auth;

use Carbon\Carbon;

use App\Forum;
use App\Sujet;
use App\Message;
use App\User;
use App\Admin;
use App\Moderation;
use App\Exclusion;
use App\Banni;

class AdminMembre
{
	public function ban($id)
	{
		if(Auth::user()->level < 4 && !session()->has('admins_unlock')) // seul le Webmaster a le droit de bannir n'importe quel membre incluant les administrateurs.
		{
			if(User::find($id)->level > 0 && User::find($id)->level < 3)
			{
				User::where('id', $id)->update([
					'level' => 0
				]);

				return back()->with('success', 'Le membre "'.User::find($id)->pseudo.'" a été banni.');
			}

			elseif(User::find($id)->level == 0)
			{
				User::where('id', $id)->update([
					'level' => 1
				]);

				return back()->with('success', 'Le membre "'.User::find($id)->pseudo.'" a été débanni.');
			}
		}

		else
		{
			if(User::find($id)->level > 0)
			{
				User::where('id', $id)->update([
					'level' => 0
				]);

				return back()->with('success', 'Le membre "'.User::find($id)->pseudo.'" a été banni via un niveau maximum.');
			}

			elseif(User::find($id)->level == 0)
			{
				User::where('id', $id)->update([
					'level' => 1
				]);

				return back()->with('success', 'Le membre "'.User::find($id)->pseudo.'" a été débanni via un niveau maximum.');
			}
		}
	}

	public function promoteAdmin($id, $request) // sert à désigner un administrateur
	{
		$secret = bcrypt($request->input('secret_password'));
		$date = \Carbon\Carbon::now();

		User::where('id', $id)
		->update([
			'level' => 3
		]);

		Admin::insert([
			'utilisateurs_id' => $id,
			'secret_password' => $secret,
			'created_at' => $date,
			'updated_at' => $date
		]);

		return redirect('admin/membre')->with('success', 'Le membre "'.User::find($id)->pseudo.'" a été promu administrateur.<br /><br />
		<strong>Son mot de passe secret est "'.e($request->input('secret_password')).'".</strong><br />
		Il doit être conservé précieusement et connu uniquement du concerné.');

	}

	public function retrogradeAdmin($id)
	{
		User::where('id', $id)
		->update([
			'level' => 1
		]);

		Admin::where('utilisateurs_id', $id)->delete();

		return back()->with('success', 'Le membre "'.User::find($id)->pseudo.'" a été rétrogradé.');
	}

	public function promoteModeration($id, $request, $isMandat = 0) {
		$secret_password = bcrypt($request->input('secret_password'));
		$forum = $request->input('forum');
		$mandatDebut = Carbon::parse($request->input('mandat_debut'));
		$mandatIndefinie = $request->input('mandat_indefinie');
		$date = Carbon::now();

		if($mandatIndefinie == 1) { // si la case durée indéfinie a été cochée
			$mandatFin = Carbon::now()->addYears(10);
		} else {
			$mandatFin = Carbon::parse($request->input('mandat_fin'));
		}

		if($isMandat) { // si c'est un ajout de mandat, on retrouve l'ancien pass de modération
			$secret_password = Moderation::where('utilisateurs_id', $id)->first()->secret_password;
		}

		if(User::find($id)) {
			if($mandatIndefinie == 1 && empty($request->input('mandat_fin'))
			OR $mandatIndefinie == 0 && !empty($request->input('mandat_fin'))
			OR $mandatIndefinie == 1 && !empty($request->input('mandat_fin'))) {
				if(Forum::find($forum)) {
					if($mandatFin >= Carbon::now()) {
						if(Moderation::where([
							['forum_id', $forum],
							['utilisateurs_id', $id],
							['mandat_fin', '>', $date],
						])->count() == 0) {
							Moderation::insert([
								'utilisateurs_id' => $id,
								'forum_id' => $forum,
								'secret_password' => $secret_password,
								'mandat_debut' => $mandatDebut,
								'mandat_fin' => $mandatFin,
								'created_at' => $date,
								'updated_at' => $date
							]);

							User::where('id', $id)
							->update([
								'level' => 2
							]);
							if($isMandat) {
								return back()->with('success', "Le forum ".Forum::find($forum)->nom." a été ajouté à la liste des mandats du modérateur ".User::find($id)->pseudo);
							}

							return back()->with('success', User::find($id)->pseudo." est maintenant modérateur du forum ".Forum::find($forum)->nom.".
							<br />
							<strong>Sa clé de déverrouillage est : ".$request->input('secret_password')."</strong>
							<br />
							Transmettez-le au modérateur et informez-le du caractère unique et inchangeable de cette clé.");

						} else { return back()->with('warning', "Ce membre modère déjà ce forum."); }
					} else { return back()->with('warning', "La date de fin du mandat doit être supérieure à aujourd'hui."); }
				} else { return back()->with('warning', "Le forum choisi n'existe pas."); }
			} else { return back()->with('warning', "Vous devez compléter la date de fin du mandat."); }
		} else { return back()->with('warning', "Cet utilisateur n'existe pas."); }
	}

	public function deleteModeration($id) { // suppression d'un mandat
		if(Moderation::find($id)) {
			Moderation::where('id', $id)->delete();
			return back()->with('success', "Le mandat a bien été supprimé.");
		} else { return back()->with('warning', "Ce mandat n'existe pas."); }
	}

	public function keyModeration($id, $request) { // mise à jour de la clé de déverrouillage du modérateur
		$secret_password = bcrypt($request->input('secret_password'));

		if(Moderation::where('utilisateurs_id', $id)->count() > 0) {
			Moderation::where('utilisateurs_id', $id)->update([
				'secret_password' => $secret_password
			]);

			return back()->with('success', "La clé de déverrouillage de ".User::find($id)->pseudo." a bien été mis à jour.
			<br />
			<strong>Sa clé de déverrouillage est : ".$request->input('secret_password')."</strong>
			<br />
			Transmettez-le au modérateur.");
		} else { return back()->with('warning', "Ce modérateur n'existe pas."); }
	}

	public function vider($id) // Vide tous les sujets et messages créé par l'utilisateur.
	{
		$sujet = Sujet::where('utilisateurs_id', $id)->get();
		$message = Message::where('utilisateurs_id', $id)->get();

		foreach($sujet as $sujets)
		{
			Sujet::where('id', $sujets->id)->update(['status' => 0]);
		}

		// Il est possible d'effectuer une condition dans chacun des foreach afin d'optimiser le calcul des recherches. Mais dans l'immédiat, ce n'est pas nécessaire.
		foreach($message as $messages)
		{
			$idSujet = $messages->sujet_id;

			if($messages->id == Message::where('sujet_id', $idSujet)->orderBy('created_at', 'ASC')->first()->id)
			{
				Sujet::where('id', $idSujet)->update(['status' => 0]);
			}

			Message::where('id', $messages->id)->update(['status' => 0]);
		}

		return back()->with('success', "L'ensemble des messages de ".User::find($id)->pseudo." ont été supprimés.");
	}
}
