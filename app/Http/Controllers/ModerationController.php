<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Forum;
use App\User;
use App\Sujet;
use App\Message;

use Carbon\Carbon;

use App\Http\Requests\ModerationUnlockRequest;

use App\Repository\Moderation\Unlock;
use App\Repository\Message\Delete as MessageDelete;
use App\Repository\Sujet\Delete as SujetDelete;
use App\Repository\Utilisateurs\Identificate;
use App\Repository\Utilisateurs\Sanction;
use App\Repository\Temps\Temps;

use App\Repository\Sujet\Delete;
use App\Repository\Sujet\Epingle;
use App\Repository\Sujet\Verrouille;

use App\Http\Requests\ModerationExclusionRequest;

class ModerationController extends Controller
{
	/*
	// Modération des sujets
	Route::get('sujet/mod/delete/{id}', 'ModerationController@sujetDestroy');
	Route::get('sujet/mod/epingle/{id}', 'ModerationController@sujetEpingle');
	Route::get('sujet/mod/verrouille/{id}', 'ModerationController@sujetVerrouille');
	Route::get('message/mod/delete/{id}', 'ModerationController@messageDestroy');
	*/
	public function __construct() {
		// Le controller est réservé aux modérateurs
		$this->middleware('moderation', ['except' => [
			'getUnlock',
			'postUnlock',
		]]);

		// Fonctions disponible uniquement aux modérateurs n'ayant pas encore déverrouillé leurs droits
		$this->middleware('moderationLevel', ['only' => [
			'getUnlock',
			'postUnlock',
		]]);

		// On vérifie au niveau HTTP si le forum ou message de l'exclusion voulue existe
		$this->middleware('exclusionExist', ['only' => [
			'getExclusion',
			'postExclusion',
		]]);
	}

	public function getUnlock() {
		return view('moderation.unlock');
	}

	public function postUnlock(ModerationUnlockRequest $request, Unlock $unlock) {
		return $unlock->exec($request);
	}

	public function sujetDestroy($id) {
			$delete = new Delete;
	    return $delete->exec($id);
	}

	public function sujetEpingle($id) {
		$epingle = new Epingle;

		if(Sujet::find($id)->status == 1)
		{
			return $epingle->exec($id);
		}

		elseif(Sujet::find($id)->status == 2)
		{
			return $epingle->unexec($id);
		}

		else
		{
			return redirect('error')->with('error', "Vous ne pouvez pas épingler ce sujet.");
		}
	}

	public function sujetVerrouille($id) {
		$verrouille = new Verrouille;

		if(Sujet::find($id)->ouvert == 1)
		{
			return $verrouille->exec($id);
		}

		else
		{
			return $verrouille->unexec($id);
		}
	}

	public function messageDestroy($id) {
		$delete = new MessageDelete;
	    return $delete->exec($id);
	}

	public function getExclusion($id, $idForum, $idMessage, Identificate $identificate, Forum $forum, Message $message)
	{
		return view('moderation.exclusion-exec')->with([
			'id' => $id,
			'idForum' => $idForum,
			'idMessage' => $idMessage,
			'identificate' => $identificate,
			'forum' => $forum,
			'message' => $message
		]);
	}

	public function postExclusion($id, $idForum, $idMessage, ModerationExclusionRequest $request, Sanction $sanction)
	{
		return $sanction->execExclusion($id, $idForum, $idMessage, $request, 1);
	}
}
