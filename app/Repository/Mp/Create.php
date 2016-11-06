<?php

namespace App\Repository\Mp;

// Chargement de la base de donnée
use DB;
use Auth;
use Crypt;

use App\User;
use App\Mp;
use App\Mp_participants;
use App\Vu;
use App\Repository\Message\Find;
use App\Repository\Utilisateurs\Identificate;

class Create
{
	public function poste($request)
	{
		$find = new Find;

		if(User::where('pseudo', $request->input('destinataire'))->count() > 0)
		{
			if(User::where('pseudo', $request->input('destinataire'))->first()->id != Auth::user()->id)
			{
				$destinataireId = User::where('pseudo', $request->input('destinataire'))->first()->id;

				$titre = $request->input('titre');
				$contenu = $request->input('contenu');
				$date = \Carbon\Carbon::now();

				// On ajoute le sujet
				$idSujet = DB::table('mps_sujets')->insertGetId([
					'utilisateurs_id' => Auth::user()->id,
					'titre' => $titre,
					'status' => 1,
					'ouvert' => 1,
					'ip' => \app\Http\Helperfunctions::getIp(),
					'created_at' => $date,
					'updated_at' => $date
				]);

				// On ajoute le premier message
				$idMessage = DB::table('mps')->insertGetId([
					'id_mp' => $idSujet,
					'utilisateurs_id' => Auth::user()->id,
					'contenu' => $contenu,
					'status' => 1,
					'ip' => \app\Http\Helperfunctions::getIp(),
					'created_at' => $date,
					'updated_at' => $date
				]);

				// C'est pas très propre mais bon ...
				// On ajoute les deux participants par défaut : l'expéditeur et le destinataire.
				DB::table('mps_participants')->insertGetId([
					'id_mp' => $idSujet,
					'utilisateurs_id' => Auth::user()->id,
					'created_at' => $date,
					'updated_at' => $date
				]);

				DB::table('mps_participants')->insertGetId([
					'id_mp' => $idSujet,
					'utilisateurs_id' => $destinataireId,
					'created_at' => $date,
					'updated_at' => $date
				]);

				// On met en vu le premier message par l'expéditeur puisque c'est son propre message.
				DB::table('vus')->insertGetId([
					'location' => 2,
					'location_id' => $idMessage, // on a déjà lu le message qu'on vient d'ajouter, normal
					'utilisateurs_id' => Auth::user()->id,
					'ip' => \app\Http\Helperfunctions::getIp(),
					'created_at' => $date,
					'updated_at' => $date
				]);

				return redirect('mp/'.$idSujet.'/'.str_slug($titre))->with('success', "Votre message privé a bien été envoyé.");
			}

			else
			{
				return back()->with('warning', "Vous ne pouvez pas envoyer un message à vous-même.");
			}
		}

		else
		{
			return back()->with('warning', "Le pseudo entré n'existe pas.");
		}
	}

	public function answer($request)
	{
		$find = new Find;
		$contenu = $request->input('contenu');
		$date = \Carbon\Carbon::now();
		$idLast = DB::table('mps')->insertGetId([
			'id_mp' => $request->id,
			'utilisateurs_id' => Auth::user()->id,
			'contenu' => $contenu,
			'status' => 1,
			'ip' => \app\Http\Helperfunctions::getIp(),
			'created_at' => $date,
			'updated_at' => $date
		]);

		// On met en vu le message envoyé par l'auteur.
		DB::table('vus')->insertGetId([
			'location' => 2,
			'location_id' => $idLast,
			'utilisateurs_id' => Auth::user()->id,
			'ip' => \app\Http\Helperfunctions::getIp(),
			'created_at' => $date,
			'updated_at' => $date
		]);

		return redirect($find->url($idLast, 'mp'))->with('success', "Votre message a bien été posté.");
	}

	public function participant($id_mp, $idMembre)
	{
		$date = \Carbon\Carbon::now();
		$identificate = new Identificate;

		$idLast = DB::table('mps_participants')->insertGetId([
			'id_mp' => $id_mp,
			'utilisateurs_id' => $idMembre,
			'created_at' => $date,
			'updated_at' => $date
		]);

		return back()->with('success', '"'.$identificate->pseudo($idMembre).'" a bien été ajouté dans la liste des participants.');
	}
}
