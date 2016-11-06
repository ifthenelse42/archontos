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

class AdminForum
{
	public function add($request)
	{
		if(Forum_categorie::find($request->input('categorie')))
		{
			$date = \Carbon\Carbon::now();
			$nom = $request->input('nom');
			$categorie = $request->input('categorie');
			$description = $request->input('description');

			// Rajouter le champs "type"
			DB::table('forum')->insert([
				'categorie_id' => $categorie,
				'nom' => $nom,
				'description' => $description,
				'created_at' => $date,
				'updated_at' => $date,
			]);

			return back()->with('success', 'Le forum "'.$nom.'" a bien été créé.');
		}

		return back()->with('warning', "La catégorie #".e($request->input('categorie'))." n'existe pas.");
	}

	public function edit($id, $request)
	{
		if(Forum_categorie::find($request->input('categorie')))
		{
			$date = \Carbon\Carbon::now();
			$nom = $request->input('nom');
			$categorie = $request->input('categorie');
			$description = $request->input('description');

			// Rajouter le champs "type"
			DB::table('forum')
			->where('id', $id)
			->update([
				'categorie_id' => $categorie,
				'nom' => $nom,
				'description' => $description,
				'updated_at' => $date,
			]);

			return back()->with('success', 'Le forum #'.$id.' a bien été modifié.');
		}

		return back()->with('warning', "La catégorie #".e($request->input('categorie'))." n'existe pas.");
	}

	public function delete($id) // SUPPRIME TOUS incluant le forum, ses sujets et ses messages, sans les rendres invisible.
	{
		// L'effet cascade désignée dans la base de donnée via les migrations s'occupera de supprimer tous les sujets et message appartenant au forum.
		Forum::where('id', $id)->delete();

		return back()->with('error', "Le forum #".$id." a bien été supprimé.");
	}

	public function vider($id)
	{
		// L'effet cascade désignée dans la base de donnée via les migrations s'occupera de supprimer tous les sujets et message appartenant au forum.
		Sujet::where('forum_id', $id)->delete();

		return back()->with('error', "Le forum #".$id." a bien été vidé de l'ensemble de ses messages.");
	}
}
