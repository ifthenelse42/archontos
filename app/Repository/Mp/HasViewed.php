<?php

namespace App\Repository\Mp;

// Chargement de la base de donnée
use DB;
use Auth;

use App\Http\Requests;

use App\User;
use App\Mp;
use App\Mp_sujet;
use App\Mp_participants;
use App\Vu;

use App\Repository\Temps\Temps;

class HasViewed
{
	public function add($id) // l'id du message et pas du "sujet" du message
	{
		$date = \Carbon\Carbon::now();

		if(Vu::
		where('location_id', $id)
		->where('utilisateurs_id', Auth::user()
		->id)->count() == 0)
		{
			DB::table('vus')->insertGetId([
				'location' => 2,
				'location_id' => $id,
				'utilisateurs_id' => Auth::user()->id,
				'ip' => \app\Http\Helperfunctions::getIp(),
				'created_at' => $date,
				'updated_at' => $date
			]);
		}
	}

	// FONCTION NON TERMINE \\
	public function addAll() // ajoute TOUS les messages non lu en lu.
	{
		$data = Mp::join('mps_participants', 'mps.id_mp', '=', 'mps_participants.id_mp')
		->select('mps.id as mpid', 'mps.*', 'mps_participants.*')
		->where('mps_participants.utilisateurs_id', Auth::user()->id)
		->where('mps.status', 1)
		->get();

		foreach($data as $datas)
		{
			$noVus = Vu::where('location_id', $datas->mpid)
			->where('utilisateurs_id', Auth::user()->id)
			->count();

			if($noVus == 0) // les messages où il n'y a pas de vus, on continue
			{
				$date = \Carbon\Carbon::now();

				DB::table('vus')->insertGetId([
					'location' => 2,
					'location_id' => $datas->mpid,
					'utilisateurs_id' => Auth::user()->id,
					'ip' => \app\Http\Helperfunctions::getIp(),
					'created_at' => $date,
					'updated_at' => $date
				]);
			}
		}

		return back()->with('success', "Tous les messages ont été marqués comme lu.");
	}

	public function get($id, $idAuteur, $mobile = 0)
	{
		$temps = new Temps();
		$vu = Vu::where('location_id', $id)
		->where('location', 2)
		->where('utilisateurs_id', '<>', $idAuteur)
		->orderBy('id', 'ASC')
		->get();

		$nbVu = Vu::where('location_id', $id)
		->where('utilisateurs_id', '<>', $idAuteur)
		->where('location', 2)
		->count();

		$liste = 'Vu par : ';

		if($nbVu == 1 && $mobile == 0)
		{
			foreach($vu as $vus)
			{
				$liste .= '<span data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" onMouseOver="this.style.cursor=\'pointer\'" data-content="'.$temps->vuMp($vus->created_at).'">'.User::find($vus->utilisateurs_id)->pseudo.'</span>';
			}
		}

		elseif($nbVu > 1 && $mobile == 0)
		{
			$countVu = 1;
			foreach($vu as $vus)
			{
				if($countVu == $nbVu)
				{
					$liste .= '<span data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" onMouseOver="this.style.cursor=\'pointer\'" data-content="'.$temps->vuMp($vus->created_at).'">'.User::find($vus->utilisateurs_id)->pseudo.'</span>';
				}

				else
				{
					$liste .= '<span data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" onMouseOver="this.style.cursor=\'pointer\'" data-content="'.$temps->vuMp($vus->created_at).'">'.User::find($vus->utilisateurs_id)->pseudo.'</span>, ';
				}

				$countVu++;
			}
		}

		elseif($mobile == 1) // version mobile
		{
			if($nbVu > 1)
			{
				$liste = 'Vu par '.$nbVu.' personnes';
			}

			elseif($nbVu == 1)
			{
				$liste = 'Vu par une personne';
			}

			else
			{
				$liste = 'Non lu';
			}
		}

		else
		{
			$liste = 'Non lu';
		}


		return $liste;
	}

	public function countNotKnown($id_mp) // Si le mp a un message non lu par l'authentifié
	{
		$nbVus = Mp::
		join('vus', 'mps.id', '=', 'vus.location_id')
		->select('mps.*', 'vus.*')
		->where('mps.id_mp', $id_mp)
		->where('vus.utilisateurs_id', Auth::user()->id)
		->count();

		$nbMessage = Mp::where('id_mp', $id_mp)
		->where('status', 1)
		->count();

		return $nbMessage - $nbVus;
	}

	public function countNotKnownAppend()
	{
		/*$nbVus = Mp::
		join('vus', 'mps.id', '=', 'vus.location_id')
		->join('mps_participants', 'mps.id_mp', '=', 'mps_participants.id_mp')
		->select('mps.id', 'mps.id_mp', 'vus.utilisateurs_id', 'vus.location_id', 'mps.status', 'mps_participants.utilisateurs_id')
		->where('vus.utilisateurs_id', Auth::user()->id)
		->where('mps.status', 1)
		->where('mps_participants.utilisateurs_id', Auth::user()->id)
		->count();

		$nbMessage = Mp::join('mps_participants', 'mps.id_mp', '=', 'mps_participants.id_mp')
		->select('mps.*', 'mps_participants.*')
		->where('mps.status', 1)
		->where('mps_participants.utilisateurs_id', Auth::user()->id)
		->count();

		return $nbMessage - $nbVus;*/

		$mp = Mp::
		join('mps_participants', 'mps.id_mp', '=', 'mps_participants.id_mp')
		->select('mps.id as id', 'mps.id_mp')
		->where('mps.status', 1)
		->where('mps_participants.utilisateurs_id', Auth::user()->id)
		->get();

		// on fait la liste des mps dont on fait partie
		// pour chaque mp, si le dernier message n'est pas lu, on ajoute 1
		$count = 0;

		foreach($mp as $mps)
		{
			$lastId = Mp::where('id_mp', $mps->id_mp)->orderBy('id', 'desc')->first()->id;

			if($lastId == $mps->id)
			{
				// si le dernier message n'est pas vu
				if(Vu::where('location_id', $lastId)
				->where('utilisateurs_id', Auth::user()->id)
				->count()
				 == 0)
				{
					$count++;
				}
			}
		}

		return $count;
	}
}
