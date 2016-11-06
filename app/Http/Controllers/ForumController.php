<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

use App\Http\Requests;
use App\Forum_categorie;
use App\Forum;
use App\Message;
use App\Sujet;

use App\Repository\Utilisateurs\Liste;
use App\Repository\Utilisateurs\Identificate;

use App\Repository\Temps\Temps;
use App\Repository\Sujet\LastMsg;
use App\Repository\Sujet\Status;
use App\Repository\Sujet\nbReponses;

use App\Repository\Message\Bbcode;
use App\Repository\Message\Smiley;
use App\Repository\Message\Find;

use App\Repository\Forum\nb;
use App\Repository\Forum\Design;
use App\Repository\Forum\Paginate;

class ForumController extends Controller
{
	// Variables globale dans le controller
	protected $paginateNb = 30;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	public function __construct()
	{
		$this->middleware('forumType', ['except' => [
			'index',
		]]);
	}

    public function index(Forum $forum, Forum_categorie $categorie, Temps $temps, LastMsg $lastMsg, Design $design, Status $status, nbReponses $nbReponses, Nb $nb)
    {
		if(Auth::check() && Auth::user()->level > 2 OR Auth::check() && Auth::user()->level == 2 && session()->has('moderation_unlock')) // s'il est connecté et plus que simple membre
		{
			return view('forum.index')->with([
				'forum' => $forum,
				'categorie' => $categorie
				->orderBy('id', 'ASC') // VOIS TOUS
				->get(),
				'temps' => $temps,
				'forum2' => new Forum(),
				'temps' => $temps,
				'design' => $design,
				'status' => $status,
				'nbReponses' => $nbReponses,
				'nb' => $nb
			]);
		}

		elseif(Auth::check() && Auth::user()->level == 0) // s'il est connecté et banni
		{
	        return view('forum.index')->with([
				'forum' => $forum,
				'categorie' => $categorie
				->orderBy('id', 'ASC')
				->where('type', '<', 2) // il voit le type 2 1 et 0
				->get(),
				'temps' => $temps,
				'forum2' => new Forum(),
				'temps' => $temps,
				'design' => $design,
				'status' => $status,
				'nbReponses' => $nbReponses,
				'nb' => $nb
			]);
		}

		elseif(Auth::check() && Auth::user()->level == 1) // s'il est connecté
		{
			return view('forum.index')->with([
				'forum' => $forum,
				'categorie' => $categorie
				->orderBy('id', 'ASC')
				->where('type', 1) // il voit le type tous
				->orWhere('type', 2) // et de type connecté
				->get(),
				'temps' => $temps,
				'forum2' => new Forum(),
				'temps' => $temps,
				'design' => $design,
				'status' => $status,
				'nbReponses' => $nbReponses,
				'nb' => $nb
			]);
		}

		else // s'il n'est pas connecté
		{
			return view('forum.index')->with([
				'forum' => $forum,
				'categorie' => $categorie
				->orderBy('id', 'ASC')
				->where('type', 1) // tous
				->get(),
				'temps' => $temps,
				'forum2' => new Forum(),
				'temps' => $temps,
				'design' => $design,
				'status' => $status,
				'nbReponses' => $nbReponses,
				'nb' => $nb
			]);
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Sujet $sujet, Identificate $identificate, Message $message, Temps $temps, LastMsg $lastMsg, Design $design, Status $status, nbReponses $nbReponses, Smiley $smiley, Bbcode $bbcode, Paginate $paginate, Liste $liste, Find $find)
    {
		// obligé de le déclarer ici
		$sujet2 = new Sujet();
		$forum2 = new Forum();

		// REQUÊTE EXTRÊMEMENT DIFFICILE. 2 JOURS D'ESSAIS ET RECHERCHES. \\
		// GG IFTHENELSE \\
		if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
		{
			return view('forum.show')->with([
				'id' => $id,
				'sujet' => $paginate->requestSujetListe($sujet, $id),
				'identificate' => $identificate,
				'message' => $message,
				'temps' => $temps,
				'forum2' => $forum2,
				'sujet2' => $sujet2->where('forum_id', $id)->count(),
				'temps' => $temps,
				'design' => $design,
				'status' => $status,
				'lastMsg' => $lastMsg,
				'nbReponses' => $nbReponses,
				'smiley' => $smiley,
				'bbcode' => $bbcode,
				'liste' => $liste,
				'find' => $find,
			]);
		}

		else
		{
			return view('forum.show')->with([
				'id' => $id,
				'sujet' => $paginate->requestSujetListe($sujet, $id),
				'identificate' => $identificate,
				'message' => $message,
				'temps' => $temps,
				'forum2' => $forum2,
				'sujet2' => $sujet2->where('forum_id', $id)->where('status', '>', 0)->count(),
				'temps' => $temps,
				'design' => $design,
				'status' => $status,
				'lastMsg' => $lastMsg,
				'nbReponses' => $nbReponses,
				'smiley' => $smiley,
				'bbcode' => $bbcode,
				'liste' => $liste,
				'find' => $find,
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
        //
    }
}
