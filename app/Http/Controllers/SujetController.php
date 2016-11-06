<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use DB;
use App\Http\Requests\SujetRequest;

use App\Sujet;
use App\Message;
use App\Forum;

use App\Repository\Sujet\Create;
use App\Repository\Sujet\Delete;
use App\Repository\Sujet\Epingle;
use App\Repository\Sujet\Verrouille;
use App\Repository\Sujet\Status;

use App\Repository\Utilisateurs\Liste;
use App\Repository\Utilisateurs\Identificate;

use App\Repository\Temps\Temps;
use App\Repository\Message\Smiley;
use App\Repository\Message\Bbcode;
use App\Repository\Message\Find;

use App\Repository\Forum\Design;
use App\Repository\Forum\Paginate;

use App\Repository\Moderation\isMod;

class SujetController extends Controller
{
	public function __construct()
	{
		$this->middleware('antiFlood', ['only' => [
			'store',
		]]);

		$this->middleware('forumType');

		$this->middleware('forumDelete', ['only' => [
			'show',
			'store',
		]]);

		$this->middleware('ifNotAuth', ['only' => [
			'store',
		]]);

		$this->middleware('admin', ['only' => [
			'destroy',
			'epingle',
			'verrouille',
		]]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Inutile.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SujetRequest $request)
    {
		$id = Request::segment(2); // PEUT GENERER DES ERREURS AVEC UN CHANGEMENT DE ROUTES
		$create = new Create; // On prend la classe Create des sujets

	    return $create->poste($id, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Message $message, Identificate $identificate, Sujet $sujet, Forum $forum, Status $status, Find $find, Temps $temps, Design $design, Smiley $smiley, Bbcode $bbcode, Paginate $paginate, Liste $liste, isMod $isMod)
    {
		if(Auth::check() && Auth::user()->level >= 3)
		{
			return view('sujet.show')->with([
				'id' => $id,
				'forum_id' => $sujet->find($id)->forum_id,
				'forum' => $forum,
				'forum_list' => $forum
				->get(),
				'message' => $paginate->requestSujet($message, $id),
				'identificate' => $identificate,
				'status' => $status,
				'find' => $find,
				'smiley' => $smiley,
				'temps' => $temps,
				'design' => $design,
				'bbcode' => $bbcode,
				'sujet' => $sujet,
				'liste' => $liste,
				'isMod' => $isMod
			]);
		}

		else
		{
			return view('sujet.show')->with([
				'id' => $id,
				'forum_id' => $sujet->find($id)->forum_id,
				'forum' => $forum,
				'forum_list' => $forum // A MODIFIER POUR LES TYPES DE CATEGORIES
				->get(),
				'message' => $paginate->requestSujet($message, $id),
				'identificate' => $identificate,
				'status' => $status,
				'find' => $find,
				'smiley' => $smiley,
				'temps' => $temps,
				'design' => $design,
				'bbcode' => $bbcode,
				'sujet' => $sujet,
				'liste' => $liste,
				'isMod' => $isMod
			]);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
		$delete = new Delete;
	    return $delete->exec($id);
    }

	public function epingle($id)
    {
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

	public function verrouille($id)
    {
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
}
