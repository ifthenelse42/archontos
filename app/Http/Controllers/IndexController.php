<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repository\Message\Find;

use App\Repository\Utilisateurs\Liste;
use App\Repository\Utilisateurs\Identificate;

use App\Repository\Temps\Temps;

use App\Repository\Sujet\LastMsg;
use App\Repository\Sujet\nbReponses;

class IndexController extends Controller
{
	public function index(Liste $liste, Identificate $identificate, Temps $temps, nbReponses $nbReponses, LastMsg $lastMsg, Find $find)
	{
		/*return view('index')->with([
			'liste' => $liste,
			'identificate' => $identificate,
			'nbReponses' => $nbReponses,
			'lastMsg' => $lastMsg,
			'find' => $find,
			'temps' => $temps
		]);*/

		return redirect('forum');
	}
}
