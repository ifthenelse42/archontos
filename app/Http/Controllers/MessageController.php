<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Message;
use App\Message_historique;

use App\Http\Requests\MessageRequest;
use App\Http\Requests\MessageEditRequest;
use App\Http\Requests\CitationRequest;

use App\Repository\Message\Create;
use App\Repository\Message\Delete;
use App\Repository\Message\Find;

use App\Repository\Forum\Design;

use App\Repository\Message\Smiley;
use App\Repository\Message\Bbcode;

use App\Repository\Temps\Temps;

use App\Repository\Utilisateurs\Identificate;

class MessageController extends Controller
{
	public function __construct()
	{
		$this->middleware('ifNotAuth', ['only' => [
			'create',
			'store',
		]]);

		$this->middleware('antiFlood', ['only' => [
			'create',
			'store',
		]]);

		$this->middleware('ifLock', ['only' => [
			'create',
			'store',
		]]);

		$this->middleware('admin', ['only' => [
			'destroy',
			'historique',
		]]);

		$this->middleware('edit', ['only' => [
			'getEdit',
			'postEdit',
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
    public function create($id_sujet, $contenu) // Faire attention au manque de Request ; lié à la fonction store() des sujets
    {
		$create = new Create; // On prend la classe Create des messages
		$find = new Find; // On prend la classe Find des messages

		return $create->poste($id_sujet, $contenu, $find);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function citation(CitationRequest $request, $id, Find $find)
	{
		return redirect($find->url($id, 'sujet', 1))->with('citation', $id);
	}

    public function store(MessageRequest $request, Find $find) // Lorsqu'on poste dans un sujet
    {
		$id = Request::segment(2); // PEUT GENERER DES ERREURS AVEC UN CHANGEMENT DE ROUTES
		$create = new Create; // On prend la classe Create des sujets

	    return $create->poste($id, $request->input('contenu'), $find);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // Servira à afficher un message, genre perma-lien
    {
        //
    }

	public function getEdit($id, Bbcode $bbcode, Smiley $smiley, Design $design)
	{
		return view('message.edit')->with([
			'id' => $id,
			'bbcode' => $bbcode,
			'smiley' => $smiley,
			'design' => $design
		]);
	}

	public function postEdit($id, MessageEditRequest $request, Create $create, Find $find)
	{
		return $create->update($id, $request, $find);
	}

	public function historique($id, Find $find, Identificate $identificate, Design $design, Smiley $smiley, Temps $temps, Bbcode $bbcode, Message_historique $message_historique)
	{
		return view('message.historique')->with([
			'id' => $id,
			'identificate' => $identificate,
			'design' => $design,
			'smiley' => $smiley,
			'temps' => $temps,
			'bbcode' => $bbcode,
			'find' => $find,
			'message_historique' => $message_historique->where('message_id', $id)->orderBy('id', 'ASC')->get(),
		]);
	}

	public function getApercu(MessageRequest $request)
	{
		return view('message.apercu');
	}

	public function postApercu(MessageRequest $request)
	{

	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

	// Aucune suppression réelle. Le message sera caché des non-admins.
    public function destroy($id)
    {
		$delete = new Delete;

	    return $delete->exec($id);
    }
}
