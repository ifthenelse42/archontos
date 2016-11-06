<?php

namespace App\Http\Controllers;

/*use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;*/

use App\Http\Requests;
use App\Http\Requests\CompteRequest;

use App\Repository\Utilisateurs\Compte;
use App\Repository\Utilisateurs\Bannir;
use App\Repository\Utilisateurs\Identificate;

use App\Repository\Forum\Design;

use App\User;
use Auth;
use Hash;

class UtilisateursController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
	/* pas sûr si c'est prudent d'exclure cette ligne */
    //use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ifNotAuth', ['only' => [
            'getProfil',
			'postProfil',
			'getIdentifiant',
			'postIdentifiant',
        ]]);

		$this->middleware('ifAuth|auth', ['only' => [
            'validator',
			'create',
        ]]);

		$this->middleware('admin', ['only' => [
            'bannir',
        ]]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

	public function index(Identificate $identificate, Design $design)
	{
		return view('utilisateurs.compte')->with([
			'identificate' => $identificate
		]);
	}

	// on réunis toute les validations en une fonction
	public function postIndex(CompteRequest $request, Compte $compte)
	{
		if($request->input('edit') == 'avatar') // si on modifie l'avatar
		{
			return $compte->updateAvatar($request);
		}

		elseif($request->input('edit') == 'email') // si on modifie l'email
		{
			return $compte->updateEmail($request);
		}

		elseif($request->input('edit') == 'password') // si on modifie le mot de passe
		{
			return $compte->updatePassword($request);
		}

		elseif($request->input('edit') == 'options') // si on modifie le mot de passe
		{
			return $compte->updateOptions($request);
		}

		elseif($request->input('edit') == 'profil') // si on modifie le mot de passe
		{
			return $compte->updateProfil($request);
		}
	}
}
