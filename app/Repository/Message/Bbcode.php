<?php

namespace App\Repository\Message;

// Chargement de la base de donnée
use DB;
use Auth;
use App\Sujet;

use App\Repository\Message\Smiley;

class Bbcode
{
	public function get($string)
	{
		// Gras
		$string = preg_replace('#\[b](.+)\[/b]#isU', '<strong>$1</strong>', $string);

		// Italique
		$string = preg_replace('#\[i](.+)\[/i]#isU', '<em>$1</em>', $string);

		// Souligné
		$string = preg_replace('#\[u](.+)\[/u]#isU', '<u>$1</u>', $string);

		// Citation
		while(preg_match('#\[citation(.*)\](.+)\[/citation\]#isU', $string)){
        	$string = preg_replace('#\[citation(.*)\](.+)\[/citation\]#isU','<blockquote><p>$2</p></blockquote>',$string);
		}

		// Spoiler
		/*$string = preg_replace('#\[spoiler](.+)\[/spoiler]#', '<button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapse-'.$tokenHide.'" aria-expanded="false" aria-controls="collapse-'.$tokenHide.'">Spoiler</button><div class="collapse" id="collapse-'.$tokenHide.'">$1</div>', $string);*/

		// Image
		$string = preg_replace('#((http://)+(i|image)+\.(imgur|noelshack)+\.(com)+\/(.*)\.(png|jpg|jpeg|gif|bmp)+)+#isU', '<a href="$1" target="_blank"><img src="$1" class="img-responsive" alt="" /></a>', $string);

		// Vidéo
		$string = preg_replace('#((http://|https://)+(?:www)+\.(youtu(?:be)\.(com)+\/watch\?v=+))+([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)#i', '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/$5" allowfullscreen></iframe></div>', $string);

		// URLS - A MODIFIER POUR PROTEGER LE LIEN
		$string = preg_replace('#(?<!\S)((http|https)+://[a-z0-9.\/_,/?!\#%&;=-]+)+#i', '<a href="$0" target="_blank">$0</a>', $string);

		return $string;
	}

	public function buttons() // renvoi les bouttons pour ajouter les bbcodes au textarea du message
	{
		$buttons =
		'<button type="button" class="bbcode-button" onclick="insertBBcode(\'messageArea\', \'[b]\', \'[/b]\');return false;"><span class="glyphicon glyphicon-bold" aria-hidden="true"></span></button>
		<button type="button" class="bbcode-button" onclick="insertBBcode(\'messageArea\', \'[i]\', \'[/i]\');return false;"><span class="glyphicon glyphicon-italic" aria-hidden="true"></span></button>
		<button type="button" class="bbcode-button" onclick="insertBBcode(\'messageArea\', \'[u]\', \'[/u]\');return false;"><span class="glyphicon glyphicon-text-color" aria-hidden="true"></span></button>
		<button type="button" class="bbcode-button" onclick="insertBBcode(\'messageArea\', \'[citation]\', \'[/citation]\');return false;"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button>
		';

		return $buttons;
	}

	public function smiley_liste() // renvoi les bouttons pour ajouter les bbcodes au textarea du message
	{
		$smiley = new Smiley;

		$buttons =
		'
		<a tabindex="0" class="visible-lg" title="Liste des smileys" data-container="body" data-toggle="popover" data-html="true" data-trigger="focus" onMouseOver="this.style.cursor=\'pointer\'" data-placement="top" data-content="'.e($smiley->listing()).'"><img src="'.asset('smileys/noel.gif').'" alt=""></a>

		<a tabindex="0" class="hidden-lg" title="Liste des smileys" data-container="body" data-toggle="popover" data-html="true" data-trigger="focus" onMouseOver="this.style.cursor=\'pointer\'" data-placement="left" data-content="'.e($smiley->listing()).'"><img src="'.asset('smileys/noel.gif').'" alt=""></a>
		';

		return $buttons;
	}
}
