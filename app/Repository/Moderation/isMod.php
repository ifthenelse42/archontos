<?php

namespace App\Repository\Moderation;

// Chargement de la base de donnée
use DB;
use Auth;

use Request;

use Carbon\Carbon;

use App\User;
use App\Moderation;
use App\Sujet;

class isMod
{
	public function exec() {
		if(Auth::check() && Auth::user()->level == 2 && session()->has('moderation_unlock') && session()->get('moderation_unlock') == TRUE) {
			if(Request::segment(1) == 'sujet') {
				$sujetId = Request::segment(2);

				if(Moderation::where([ // si il est modérateur du forum où le sujet est, et si son mandat a débuté et n'a pas fini
					['utilisateurs_id', Auth::user()->id],
					['forum_id', Sujet::find($sujetId)->forum->id],
					['mandat_debut', '<=', Carbon::now()],
					['mandat_fin', '>=', Carbon::now()],
				])->count() == 1) {
					return 1;
				} else { return 0; }
			} elseif(Request::segment(1) == 'forum') { // si il est modérateur du forum où il est, et si son mandat a débuté et n'a pas finiau
				$sujetId = Request::segment(2);

				if(Moderation::where([ // si il est modérateur du forum où le sujet est, et si son mandat est encore actif
					['utilisateurs_id', Auth::user()->id],
					['forum_id', Sujet::find($sujetId)->forum->id],
					['mandat_debut', '<=', Carbon::now()],
					['mandat_fin', '>=', Carbon::now()],
				])->count() == 1) {
					return 1;
				} else { return 0; }
			} else {
				return 0;
			}
		} else { return 0; }
	}
}
