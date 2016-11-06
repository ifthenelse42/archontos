<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\InscriptionRequest;

// Classe contenant les fonctions d'inscription
use App\Repository\Utilisateurs\Inscription;
use Auth;
use Validator;

class InscriptionController extends Controller
{
	/*protected function validator(array $data)
    {
	return Validator::make($data, [
	    'pseudo' => 'required|max:255|unique:utilisateurs',
	    'email' => 'required|email|max:255|unique:utilisateurs',
	    'password' => 'required|min:2|confirmed',
	]);
	}*/

	public function getForm()
	{
		if(Auth::check())
		{
			return redirect('/');
		}

		return view('utilisateurs.inscription');
	}

	public function postForm(InscriptionRequest $request, Inscription $inscription)
	{
		if($inscription->save($request))
		{
			return redirect('/');
		}

		else
		{
			return redirect('/');
		}
	}
}
