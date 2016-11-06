<?php

namespace App\Repository\Sujet;

// Chargement de la base de donnée
use DB;
use Auth;

use App\Message;
use App\Mp;

class nbReponses
{
	public function get($id, $location = 'sujet')
	{
		if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
		{
			if($location == 'sujet')
			{
				$nb = Message::where('sujet_id', $id)
				->count() - 1;
			}

			elseif($location == 'mp')
			{
				$nb = Mp::where('id_mp', $id)
				->count() - 1;
			}
		}

		else
		{
			if($location == 'sujet')
			{
				$nb = Message::where('sujet_id', $id)
				->where('status', 1)
				->count() - 1;
			}

			elseif($location == 'mp')
			{
				$nb = Mp::where('id_mp', $id)
				->where('status', 1)
				->count() - 1;
			}
		}

		return $nb;
	}
}
