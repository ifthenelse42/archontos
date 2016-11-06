<?php

namespace app\Http;

use Request;

use App\Forum;
use App\Sujet;

class Helperfunctions
{
	public static function getIp(){
		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
			$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

	    return $ip;
	}

	public static function breadcrumb(){ // breadcrumb affiché en haut des pages
		$segment1 = Request::segment(1);
		$segment2 = Request::segment(2);
		$segment3 = Request::segment(3);

		$breadcrumb = '<ol class="breadcrumb">';

		if($segment1 == 'sujet') { // quand on est dans un sujet
			$breadcrumb .= '<li><a href="'.url('/').'"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Accueil</a></li>';
			$breadcrumb .= '<li><a href="'.url('forum').'">Forums</a></li>';
			$breadcrumb .= '<li><a href="'.url('forum/'.Sujet::find($segment2)->forum->id.'/'.str_slug(Sujet::find($segment2)->forum->nom, '-')).'">'.Sujet::find($segment2)->forum->nom.'</a></li>';
			$breadcrumb .= '<li class="active">'.e(Sujet::find($segment2)->titre).'</li>';
		} elseif($segment1 == 'forum' && !empty($segment2)) { // quand on est dans un forum
			$breadcrumb .= '<li><a href="'.url('/').'"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Accueil</a></li>';
			$breadcrumb .= '<li><a href="'.url('forum').'">Forums</a></li>';
			$breadcrumb .= '<li class="active">'.e(Forum::find($segment2)->nom).'</li>';
		} elseif($segment1 == 'forum' && empty($segment2)) { // quand on est dans la liste des forums
			$breadcrumb .= '<li><a href="'.url('/').'"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Accueil</a></li>';
			$breadcrumb .= '<li class="active">Forums</li>';
		} elseif($segment1 == '' && empty($segment2)) { // quand on est dans l'accueil'
			$breadcrumb .= '<li class="active"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Accueil</li>';
		} elseif($segment1 == 'mp') { // quand on est dans l'accueil'
			$breadcrumb .= '<li><a href="'.url('/').'"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Accueil</a></li>';
			$breadcrumb .= '<li class="active">Messages privés</li>';
		} elseif($segment1 == 'compte') { // quand on est dans l'accueil'
			$breadcrumb .= '<li><a href="'.url('/').'"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Accueil</a></li>';
			$breadcrumb .= '<li class="active">Mon compte</li>';
		} else { return ''; }

		$breadcrumb .= '</ol>';

		return $breadcrumb;
	}
}
