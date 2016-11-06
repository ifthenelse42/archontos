<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ConnexionRequest;

// Classe contenant la vérification et connexion
use App\Repository\Utilisateurs\Check;

use Auth;

class ConnexionController extends Controller
{
	public function __construct()
    {
		$this->middleware('ifAuth', ['except' => [
			'deconnexion',
		]]);

		$this->middleware('ifNotAuth', ['only' => [
			'deconnexion',
		]]);
    }

	public function getForm()
	{
		return view('utilisateurs.connexion');
	}

	public function postForm(ConnexionRequest $request, Check $check)
	{
		if($check->validate($request))
		{
			return redirect()->intended('/');
		}

		else
		{
			// Si la connexion a échouée
			return redirect('connexion')->with('error', 'Vos identifiants sont incorrect.');
		}
	}

	public function deconnexion()
	{
		session()->flush(); // on supprime aussi toute les sessions ajoutés par mes soins tel que admins_unlock

		Auth::logout();

		return redirect('/')->with('success', "Vous êtes déconnecté.");
	}
}
