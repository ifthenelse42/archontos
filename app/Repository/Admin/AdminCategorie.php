<?php

namespace App\Repository\Admin;

// Chargement de la base de donnée
use DB;
use Auth;

use App\Forum_categorie;
use App\Forum;
use App\Sujet;
use App\Message;
use App\User;

class AdminCategorie
{
	public function add($request)
	{
		$date = \Carbon\Carbon::now();
		$nom = $request->input('nom');
		$type = $request->input('type');

		DB::table('forum_categorie')->insert([
			'nom' => $nom,
			'type' => $type,
			'created_at' => $date,
			'updated_at' => $date
		]);

		return back()->with('success', 'La catégorie "'.$nom.'" a bien été créé.');
	}

	public function edit($id, $request)
	{
		$date = \Carbon\Carbon::now();
		$nom = $request->input('nom');
		$type = $request->input('type');

		// Rajouter le champs "type"
		DB::table('forum_categorie')
		->where('id', $id)
		->update([
			'nom' => $nom,
			'type' => $type,
			'updated_at' => $date,
		]);

		return back()->with('success', 'La catégorie #'.$id.' a bien été modifié.');
	}

	public function delete($id) // SUPPRIME TOUS incluant le forum, ses sujets et ses messages, sans les rendres invisible.
	{
		// L'effet cascade désignée dans la base de donnée via les migrations s'occupera de supprimer tous les sujets et message appartenant au forum.
		Forum_categorie::where('id', $id)->delete();

		return back()->with('success', "La catégorie #".$id." a bien été supprimé.");
	}

	public function vider($id)
	{
		// L'effet cascade désignée dans la base de donnée via les migrations s'occupera de supprimer tous les sujets et message appartenant au forum.
		Forum::where('categorie_id', $id)->delete();

		return back()->with('success', "La catégorie #".$id." a bien été vidé de l'ensemble de ses forums.");
	}
}
