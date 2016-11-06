<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use Auth;

use App\Repository\Utilisateurs\Check;
use App\Repository\Utilisateurs\Compte;
use App\Repository\Utilisateurs\Identificate;

class ProfilController extends Controller
{
    public function __construct() {
        $this->middleware('profil');
    }

    public function show($pseudo, Identificate $identificate, Compte $compte) {
        $id = $identificate->id($pseudo);

        $pseudoShow = $identificate->pseudo($id);

        return view('utilisateurs.profil')->with([
            'pseudo' => $pseudoShow,
            'id' => $id,
            'identificate' => $identificate,
            'compte' => $compte
        ]);
    }
}
