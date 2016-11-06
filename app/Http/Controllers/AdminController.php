<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AdminCategorieRequest;
use App\Http\Requests\AdminForumRequest;
use App\Http\Requests\AdminPromoteAdminRequest;
use App\Http\Requests\AdminPromoteModerationRequest;
use App\Http\Requests\AdminUnlockRequest;
use App\Http\Requests\AdminModerationMandatRequest;
use App\Http\Requests\AdminModerationKeyRequest;
use App\Http\Requests\AdminExclusionRequest;

use App\Moderation;
use App\Exclusion;
use App\Message;
use App\Forum_categorie;
use App\Forum;
use App\Mp;
use App\Vu;
use App\User;
use App\Sujet;
use Auth;

use Carbon\Carbon;

use App\Repository\Utilisateurs\Identificate;
use App\Repository\Utilisateurs\Sanction;
use App\Repository\Temps\Temps;

use App\Repository\Forum\Design;

use App\Repository\Admin\AdminCategorie;
use App\Repository\Admin\AdminForum;
use App\Repository\Admin\AdminMembre;
use App\Repository\Admin\Maintenance;
use App\Repository\Admin\Unlock;

class AdminController extends Controller
{
	public function __construct()
	{
		// Fonctions disponible aux administrateurs ayant déverrouillé leurs droits
		$this->middleware('admin', ['except' => [
			'getUnlock',
			'postUnlock',
			// on empêche les administrateurs de modifier les forums
			'indexForum',
			'getEditForum',
			'postEditForum',
			'addForum',
			'deleteForum',
			'emptyForum',
			'addCategorie',
			'getEditCategorie',
			'postEditCategorie',
			'deleteCategorie',
			'emptyCategorie',
		]]);

		// Fonctions disponible uniquement aux administrateurs n'ayant pas encore déverrouillé leurs droits
		$this->middleware('adminLevel', ['only' => [
			'getUnlock',
			'postUnlock',
		]]);

		// Fonctions disponible uniquement au webmaster
		$this->middleware('webmaster', ['only' => [
			'getPromoteMembre',
			'postPromoteMembre',
			// on empêche les administrateurs de modifier les forums
			'indexForum',
			'getEditForum',
			'postEditForum',
			'addForum',
			'deleteForum',
			'emptyForum',
			'addCategorie',
			'getEditCategorie',
			'postEditCategorie',
			'deleteCategorie',
			'emptyCategorie',
		]]);
	}

	public function index(Identificate $identificate, Mp $mp, Vu $vu, User $user, Forum $forum, Message $message, Sujet $sujet, Temps $temps)
	{
		return view('admin.index')->with([
			'total_messages' => $message->count(),
			'total_sujets' => $sujet->count(),
			'total_forum' => $forum->count(),
			'total_mp' => $mp->count(),
			'total_vu' => $vu->count(),
			'total_utilisateurs' => $user->where('level', '=', 1)->count(),
			'total_banni' => $user->where('level', '=', 0)->count(),
			'total_moderateur' => $user->where('level', '=', 2)->count(),
			'total_administrateur' => $user->where('level', '>', 2)->count(),
			'temps' => $temps,
			'identificate' => $identificate
		]);
	}

	public function indexMembre(Identificate $identificate, User $user, Temps $temps)
	{
		// SEUL LE WEBMASTER PEUT VOIR LES AUTRES ADMINISTRATEURS
		if(Auth::check() && Auth::user()->level == 4 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
		{
			return view('admin.membre')->with([
				'membre' => $user->orderBy('id')->where('level', '<', 4)->get(),
				'temps' => $temps,
				'identificate' => $identificate
			]);
		}

		else
		{
			return view('admin.membre')->with([
				'membre' => $user->orderBy('id')->where('level', '<', 3)->get(),
				'temps' => $temps,
				'identificate' => $identificate
			]);
		}

	}

	public function indexModeration(Identificate $identificate, User $user, Temps $temps, Moderation $moderation, Carbon $carbon, Forum $forum)
	{
		return view('admin.moderation')->with([
			'moderation' => $moderation->orderBy('id')->groupBy('utilisateurs_id'),
			'temps' => $temps,
			'identificate' => $identificate,
			'user' => $user,
			'carbon' => $carbon,
			'forum' => $forum->get(),
			'moderationData' => $moderation
		]);
	}

	public function indexExclusion(Identificate $identificate, Exclusion $exclusion, Carbon $carbon, Temps $temps)
	{
		return view('admin.exclusion')->with([
			'exclusion' => $exclusion->orderBy('id')->groupBy('utilisateurs_id'),
			'exclusionData' => $exclusion,
			'carbon' => $carbon,
			'temps' => $temps,
			'identificate' => $identificate
		]);
	}

	public function indexForum(Identificate $identificate, Forum $forum, Message $message, Sujet $sujet, Temps $temps, Design $design, Forum_categorie $categorie)
	{
		return view('admin.forum')->with([
			'forum' => $forum->orderBy('categorie_id', 'ASC')->orderBy('id', 'ASC')->get(),
			'categorie' => $categorie,
			'sujet' => $sujet,
			'message' => $message,
			'temps' => $temps,
			'design' => $design,
			'identificate' => $identificate
		]);
	}

	public function indexMaintenance(Identificate $identificate, Temps $temps)
	{
		return view('admin.maintenance')->with([
			'temps' => $temps,
			'identificate' => $identificate
		]);
	}

	public function getEditForum($id, Forum $forum, Forum_categorie $categorie)
	{
		return view('admin.forum-edit')->with([
			'forum' => $forum->find($id),
			'categorie' => $categorie->get()
		]);
	}

	public function addForum(AdminForumRequest $request, AdminForum $adminForum)
	{
		return $adminForum->add($request);
	}

	public function postEditForum($id, AdminForumRequest $request, AdminForum $adminForum)
	{
		return $adminForum->edit($id, $request);
	}

	public function deleteForum($id, AdminForum $adminForum)
	{
		return $adminForum->delete($id);
	}

	public function emptyForum($id, AdminForum $adminForum)
	{
		return $adminForum->vider($id);
	}

	public function addCategorie(AdminCategorieRequest $request, AdminCategorie $adminCategorie)
	{
		return $adminCategorie->add($request);
	}

	public function getEditCategorie($id, Forum_categorie $categorie, AdminCategorie $adminCategorie)
	{
		return view('admin.categorie-edit')->with([
			'id' => $id,
			'categorie' => $categorie->find($id),
		]);
	}

	public function postEditCategorie($id, AdminCategorieRequest $request, AdminCategorie $adminCategorie)
	{
		return $adminCategorie->edit($id, $request);
	}

	public function deleteCategorie($id, AdminCategorie $adminCategorie)
	{
		return $adminCategorie->delete($id);
	}

	public function emptyCategorie($id, AdminCategorie $adminCategorie)
	{
		return $adminCategorie->vider($id);
	}

	public function banMembre($id, Sanction $sanction)
	{
		return $sanction->execExclusion($id);
	}

	public function getPromoteAdmin($id, Identificate $identificate, AdminMembre $adminMembre)
	{
		if(User::find($id)->level < 3)
		{
			return view('admin.promoteAdmin')->with([
				'id' => $id,
				'identificate' => $identificate
			]);
		}

		// Si l'utilisateur est déjà un administrateur, on le rétrograde
		else
		{
			return $adminMembre->retrogradeAdmin($id);
		}
	}

	public function postPromoteAdmin($id, AdminMembre $adminMembre, AdminPromoteAdminRequest $request)
	{
		if(User::find($id)->level < 3)
		{
			return $adminMembre->promoteAdmin($id, $request);
		}

		else
		{
			return $adminMembre->retrogradeAdmin($id, $request);
		}
	}

	public function getPromoteModeration($id, Identificate $identificate, Moderation $moderation, Forum $forum)
	{
		return view('admin.promoteModeration')->with([
			'id' => $id,
			'identificate' => $identificate,
			'forum' => $forum->get()
		]);

	}

	public function postPromoteModeration($id, AdminMembre $adminMembre, AdminPromoteModerationRequest $request)
	{
		return $adminMembre->promoteModeration($id, $request);
	}

	public function emptyMembre($id, AdminMembre $adminMembre)
	{
		return $adminMembre->vider($id);
	}

	public function lockdown(Maintenance $maintenance)
	{
		return $maintenance->lockdown();
	}

	public function getUnlock()
	{
		return view('admin.unlock');
	}

	public function postUnlock(AdminUnlockRequest $request, Unlock $unlock)
	{
		return $unlock->poste($request);
	}

	public function postModerationMandat($id, AdminModerationMandatRequest $request, AdminMembre $adminMembre)
	{
		return $adminMembre->promoteModeration($id, $request, 1);
	}

	public function postModerationKey($id, AdminModerationKeyRequest $request, AdminMembre $adminMembre)
	{
		return $adminMembre->keyModeration($id, $request);
	}

	public function deleteModerationMandat($id, AdminMembre $adminMembre)
	{
		return $adminMembre->deleteModeration($id);
	}

	public function getExclusion($id, $idForum, $idMessage, Identificate $identificate, Forum $forum, Message $message)
	{
		return view('admin.exclusion-exec')->with([
			'id' => $id,
			'idForum' => $idForum,
			'idMessage' => $idMessage,
			'identificate' => $identificate,
			'forum' => $forum,
			'message' => $message
		]);
	}

	public function postExclusion($id, $idForum, $idMessage, AdminExclusionRequest $request, Sanction $sanction)
	{
		return $sanction->execExclusion($id, $idForum, $idMessage, $request);
	}

	public function deleteExclusion($id, Sanction $sanction)
	{
		return $sanction->unexecExclusion($id);
	}
}
