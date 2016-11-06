<?php

namespace App\Repository\Sujet;

// Chargement de la base de donnée
use DB;
use Auth;
use App\Http\Controllers\MessageController;

class Create
{
	public function poste($id, $request)
	{
		$message = new MessageController;
		$titre = $request->input('titre');
		$contenu = $request->input('contenu');

		$date = \Carbon\Carbon::now();

		$id_sujet = DB::table('sujet')->insertGetId([
			'forum_id' => $id,
			'utilisateurs_id' => Auth::id(),
			'titre' => $titre,
			'status' => 1,
			'ouvert' => 1,
			'anonymous' => Auth::user()->anonymous,
			'ip' => \app\Http\Helperfunctions::getIp(),
			'created_at' => $date,
			'updated_at' => $date
		]);

		// On envoie les données au controller Message pour enregistrer le premier message
		return $message->create($id_sujet, $contenu);
	}
}
