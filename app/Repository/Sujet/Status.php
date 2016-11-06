<?php

namespace App\Repository\Sujet;

// Chargement de la base de donnée
use DB;

class Status
{
	public function get($status, $ouvert, $nbReponses)
	{
		if($status == 2) {// si c'est épinglé
			if($ouvert == 1) {
				return 'glyphicon glyphicon-pushpin dossier-epingle';
			} else {
				return 'glyphicon glyphicon-pushpin dossier dossier-lock';
			}
		} elseif($status == 1 && $ouvert == 1) { // si c'est un sujet simple
			if($nbReponses <= 20) {
				return 'glyphicon glyphicon-folder-close dossier dossier-normal';
			} elseif($nbReponses >= 20) {
				return 'glyphicon glyphicon-folder-close dossier dossier-2';
			} elseif($nbReponses >= 100) {
				return 'glyphicon glyphicon-folder-close dossier dossier-3';
			}
		} elseif($ouvert == 0) {// si c'est un sujet supprimé
			return 'glyphicon glyphicon-lock dossier dossier-lock';
		} elseif($status == 0) {// si c'est un sujet supprimé
			return 'glyphicon glyphicon-ban-circle dossier-x';
		}
	}

	public function message($status)
	{
		if($status == 0)
		{
			return 'well-erty';
		}

		else
		{
			return '';
		}
	}
}
