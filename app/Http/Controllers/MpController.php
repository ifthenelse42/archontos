<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MpNewRequest;
use App\Http\Requests\MpRequest;
use App\Http\Requests\MpParticipantRequest;

use Auth;
use DB;
use Crypt;

use App\Mp;
use App\User;
use App\Mp_participants;
use App\Mp_sujet;
use App\Repository\Mp\Create;
use App\Repository\Mp\Delete;
use App\Repository\Mp\Participant;
use App\Repository\Mp\HasViewed;
use App\Repository\Message\Smiley;
use App\Repository\Message\Bbcode;

use App\Repository\Utilisateurs\Identificate;

use App\Repository\Forum\Design;
use App\Repository\Forum\Paginate;

class MpController extends Controller
{
	public function __construct()
	{
		$this->middleware('ifNotAuth');

		$this->middleware('mpPrivate', ['except' => [
			'index',
			'getNew',
			'postNew',
			'vuAll',
			'deleteAll',
			'destroy',
		]]);

		$this->middleware('antiFlood', ['only' => [
			'store',
			'postNew',
		]]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mp $mp, Mp_sujet $mp_sujet, Identificate $identificate, Crypt $crypt, Design $design, Paginate $paginate)
    {
		return view('mp.liste')->with([
			'mp_sujet' => $paginate->requestMpListe($mp_sujet),
			'mp_participant' => new Mp_participants,
			'mp_data' => $mp,
			'crypt' => $crypt,
			'design' => $design,
			'identificate' => $identificate
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew(Design $design, Bbcode $bbcode, Smiley $smiley, Identificate $identificate)
    {
		return view('mp.new')->with([
			'design' => $design,
			'bbcode' => $bbcode,
			'smiley' => $smiley
		]);
    }

	public function getNewWithDestinataire(Design $design, Bbcode $bbcode, Smiley $smiley, Identificate $identificate, $destinataire)
    {
		// Flemme de créer un middleware juste pour ça alors ...
		if(User::select('pseudo', 'id')->where('pseudo', $destinataire)->count() > 0) {
			$id = $identificate->id($destinataire);

			return view('mp.new')->with([
				'design' => $design,
				'bbcode' => $bbcode,
				'smiley' => $smiley,
				'id' => $id
			]);
		} else {
			return redirect('forum')->with('warning', "Ce membre n'existe pas.");
		}
    }

	public function postNew(MpNewRequest $request, Create $create)
    {
		return $create->poste($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MpRequest $request, Create $create) // répondre à un message
    {
		return $create->answer($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Mp $mp, Mp_sujet $mp_sujet, Mp_participants $mp_participants, Identificate $identificate, HasViewed $hasViewed, Design $design, Bbcode $bbcode, Smiley $smiley, Paginate $paginate)
    {
        return view('mp.show')->with([
			'id' => $id,
			'mp' => $paginate->requestMp($mp, $id),
			'mp_participants' => $mp_participants
			->where('id_mp', $id)
			->get(),
			'mp_sujet_data' => $mp_sujet,
			'idAuteur' => Mp::where('id_mp', $id)->first()->utilisateurs_id,
			'identificate' => $identificate,
			'hasViewed' => $hasViewed,
			'design' => $design,
			'bbcode' => $bbcode,
			'smiley' => $smiley
		]);
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

	 public function addParticipants(MpParticipantRequest $request, Create $create, Mp_participants $mp_participants, Mp $mp, Identificate $identificate)
     {
		 if(Mp::where('id_mp', $request->id)->first()->utilisateurs_id == Auth::user()->id)
		 {
			 if($identificate->existByPseudo($request->input('pseudo')) > 0)
			 {
				 $idMembre = $identificate->id($request->input('pseudo'));

				 if($mp_participants
				 ->where('utilisateurs_id', $idMembre)
				 ->where('id_mp', $request->id)
				 ->count() == 0)
				 {
					 return $create->participant($request->id, $idMembre);
				 }

				 else
				 {
					 return back()->with('warning', "Ce membre fait déjà parti des participants.");
				 }
		 	}

			else
			{
				return back()->with('warning', "Ce membre n'existe pas.");
			}
		}

		else
		{
			return back()->with('warning', "Vous ne pouvez pas ajouter de participant.");
		}
     }

	 public function deleteParticipants($id_mp, $idMembre, Delete $delete)
     {
		$idAuteur = Mp::where('id_mp', $id_mp)->first()->utilisateurs_id;

		if($idMembre != $idAuteur)
		{
 			return $delete->participant($id_mp, $idMembre);
		}

		else
		{
			return back()->with('warning', "Vous ne pouvez vous retirer vous-même du message privé.");
		}
     }

	 public function leaveParticipant($id, Delete $delete)
     {
 		return $delete->self($id);
     }

	 public function vuAll(HasViewed $hasViewed)
	 {
		 return $hasViewed->addAll();
	 }

	 public function deleteAll(Delete $delete)
	 {
		 return $delete->all();
	 }

    public function destroy($id)
    {

    }
}
