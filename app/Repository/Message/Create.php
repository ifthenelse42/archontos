<?php

namespace App\Repository\Message;

// Chargement de la base de donnée
use DB;
use Auth;
use App\Sujet;

class Create
{
	public function poste($id_sujet, $contenu, $find)
	{
		$date = \Carbon\Carbon::now();
		$sujet = new Sujet;

		$idNouveau = DB::table('message')->insertGetId([
			'sujet_id' => $id_sujet,
			'utilisateurs_id' => Auth::id(),
			'contenu' => $contenu,
			'status' => 1,
			'anonymous' => Auth::user()->anonymous,
			'ip' => \app\Http\Helperfunctions::getIp(),
			'created_at' => $date,
			'updated_at' => $date
		]);

		DB::table('message_historique')->insertGetId([
			'message_id' => $idNouveau,
			'utilisateurs_id' => Auth::id(),
			'contenu' => $contenu,
			'ip' => \app\Http\Helperfunctions::getIp(),
			'created_at' => $date,
			'updated_at' => $date
		]);

		// Redirection automatique vers la position du nouveau message
		return redirect($find->url($idNouveau))->with('success', "Votre message a bien été enregistré.");
	}

	public function update($id, $request, $find) {
		$date = \Carbon\Carbon::now();

		DB::table('message')
		->where('id', $id)
		->update([
			'contenu' => $request->input('contenu'),
			'updated_at' => $date
		]);

		$idNouveau = DB::table('message_historique')->insertGetId([
			'message_id' => $id,
			'utilisateurs_id' => Auth::id(),
			'contenu' => $request->input('contenu'),
			'ip' => \app\Http\Helperfunctions::getIp(),
			'created_at' => $date,
			'updated_at' => $date
		]);

		// Redirection automatique vers la position du message
		return redirect($find->url($id))->with('success', "Le message a bien été modifié.");
	}
}
