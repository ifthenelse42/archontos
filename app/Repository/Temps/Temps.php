<?php

namespace App\Repository\Temps;

use Carbon\Carbon;

class Temps
{
	public function message($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$joursDiff = $init->diffInDays(Carbon::now());
		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');

		$heures = $init->format('H');
		$minutes = $init->format('i');
		$secondes = $init->format('s');

		if($joursDiff > 0)
		{
			return $jours.'/'.$mois.'/'.$annee.' à '.$heures.':'.$minutes.':'.$secondes;
		}

		else
		{
			// inutile de le personnaliser
			return $init->diffForHumans(Carbon::now());
		}
	}

	public function sujet($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$joursDiff = $init->diffInDays(Carbon::now());

		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');

		if($joursDiff > 0)
		{
			return $jours.'/'.$mois.'/'.$annee;
		}

		else
		{
			// inutile de le personnaliser
			return $init->toTimeString();
		}
	}

	public function date1($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');


		return $jours.'/'.$mois.'/'.$annee;
	}

	public function date2($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');


		return $annee.'-'.$mois.'-'.$jours;
	}

	public function date3($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');

		$secondes = $init->format('s');
		$minutes = $init->format('i');
		$heures = $init->format('H');


		return $jours.'/'.$mois.'/'.$annee.' à '.$heures.':'.$minutes.':'.$secondes;
	}

	public function sujetLastMsg($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		return $init->toTimeString();
	}

	public function nbJours($date)
	{
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$jours = $init->diffInDays(Carbon::now());


		if($jours == 0)
		{
			return $jours.' jour';
		}

		else
		{
			return $jours.' jours';
		}
	}

	public function moisHuman($month)
	{
		switch($month)
		{
			case 12:
				$mois = 'décembre';
			break;

			case 11:
				$mois = 'novembre';
			break;

			case 10:
				$mois = 'octobre';
			break;

			case 9:
				$mois = 'septembre';
			break;

			case 8:
				$mois = 'août';
			break;

			case 7:
				$mois = 'juillet';
			break;

			case 6:
				$mois = 'juin';
			break;

			case 5:
				$mois = 'mai';
			break;

			case 4:
				$mois = 'avril';
			break;

			case 3:
				$mois = 'mars';
			break;

			case 2:
				$mois = 'février';
			break;

			case 1:
				$mois = 'janvier';
			break;
		}

		return $mois;
	}

	public function vuMp($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$joursDiff = $init->diffInDays(Carbon::now());
		$moisDiff = $init->diffInMonths(Carbon::now());
		$anneeDiff = $init->diffInYears(Carbon::now());
		$jours = $init->day;

		$mois = Temps::moisHuman($init->month);
		$annee = $init->year;

		$heure = $init->format('H');
		$minute = $init->format('i');

		if($joursDiff == 1)
		{
			return "Vu hier à ".$heure.":".$minute;
		}

		elseif($joursDiff > 1)
		{
			return "Vu le ".$jours." ".$mois." ".$annee." à ".$heure.":".$minute;
		}

		else
		{
			return "Vu à ".$heure.":".$minute;
		}
	}
}
