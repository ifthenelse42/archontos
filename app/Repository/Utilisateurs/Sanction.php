<?php

namespace App\Repository\Utilisateurs;

// Chargement de la base de donnée
use DB;
use Auth;
use Request;

use Carbon\Carbon;

use App\Sujet;
use App\Message;
use App\User;
use App\Exclusion;

use App\Repository\Utilisateurs\Identificate;

use App\Http\Controllers\SujetController;

class Sanction
{
	/* Les 3 dernières variables sont optionnelles */
	public function execExclusion($id, $idForum = 0, $idMessage = 0, $request = '', $mod = 0)
	{
		$identificate = new Identificate;
		/* TYPE REMAINS :
		1 : heures
		2 : jours
		3 : mois
		4 : années

		TYPE EXCLUSIONS :
		1 : FORUM
		2 : GLOBAL
		3 : LOCK
		*/

		if(!empty($request)) {
			if($mod == 1) {
				$type = 1;
			} else {
				$type = $request->input('type');
			}

			$typeRemain = $request->input('type-remain');

			switch($typeRemain) {
				case 1: // heures
					$remain = Carbon::now()->addHours($request->input('remain'));
				break;

				case 2: // jours
					$remain = Carbon::now()->addDays($request->input('remain'));
				break;

				case 3: // mois
					$remain = Carbon::now()->addMonths($request->input('remain'));
				break;

				case 4: // années
					$remain = Carbon::now()->addYears($request->input('remain'));
				break;

				default:
					$remain = Carbon::now()->addYears(10);
				break;
			}

			if(empty($request->input('definitive'))) {
				$definitive = 0;
			} else { $definitive = 1; $remain = Carbon::now()->addYears(10); }

			switch($type) {
				case 1: // d'un forum
					$idForum = $idForum;
					$idMessage = $idMessage;
				break;

				case 2: // globalement
					$idForum = 0;
					$idMessage = 0;

				break;

				case 3: // verrouillage
					$idForum = 0;
					$idMessage = 0;
				break;

				default:
					$idForum = $idForum;
					$idMessage = $idMessage;
				break;
			}

		} else { // si ça n'est pas fait depuis un formulaire, on considère que c'est une exclusion permanente de type verrouillage
			$definitive = 1;
			$remain = Carbon::now()->addYears(10);
			$type = 3;
			$typeRemain = '';
		}

		if(User::find($id)) {
			if(Exclusion::where([
					['utilisateurs_id', $id],
					['remain', '>=', Carbon::now()],
					['forum_id', $idForum],
				])->count() == 0) {
				if($definitive == 1 && empty($remain)
				OR $definitive == 0 && !empty($remain)
				OR $definitive == 1 && !empty($remain)) {
					$date = Carbon::now();

					Exclusion::insert([
						'utilisateurs_id' => $id,
						'byUtilisateurs_id' => Auth::user()->id,
						'forum_id' => $idForum,
						'message_id' => $idMessage,
						'definitive' => $definitive,
						'type' => $type,
						'remain' => $remain,
						'created_at' => $date,
						'updated_at' => $date
					]);

					if($mod == 1) { // si on est modérateur, on est pas redirigé vers la gestion des exclusions des administrateurs
						return back()->with('success',
						"
						Le membre \"".$identificate->pseudo($id)."\" a bien été exclu.
						");
					}
					return redirect('admin/exclusion')->with('success',
					"
					Le membre \"".$identificate->pseudo($id)."\" a bien été exclu.
					");
				} else { return back()->with('warning', "Vous devez remplir la case \"Durée\"."); }
			} else { return back()->with('warning', "Cet utilisateur est déjà exclu."); }
		} else { return back()->with('warning', "Cet utilisateur n'existe pas."); }
	}

	public function unexecExclusion($id) // lorsque l'on "supprime" une exclusion, en réalité, on passe la date de l'exclusion a maintenant.
	{
		$date = Carbon::now();

		if(Exclusion::find($id)) {
			$ancienneDate = Exclusion::find($id)->remain;
			Exclusion::where('id', $id)
			->update([
				'definitive' => 0,
				'remain' => $date,
				'updated_at' => $ancienneDate
	 		]);

			return back()->with('success', "L'exclusion selectionnée a bien été rendue inactive.");
		} else { return back()->with('warning', "L'exclusion selectionnée n'existe pas."); }
	}
}
