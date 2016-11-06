<?php

namespace App\Repository\Mp;

// Chargement de la base de donnée
use DB;
use App\Mp;

class LastMsg
{
	public function get($id_mp)
	{
		return Mp::where('id_mp', $id_mp)
		->orderBy('created_at', 'DESC')
		->first();
	}
}
