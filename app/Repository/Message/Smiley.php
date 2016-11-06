<?php

namespace App\Repository\Message;

class Smiley
{
	private $smileyPerMessage = 40;

	public function list() {
		$smiley =
	    [
			// DEBUT SMILEYS DE JEUXVIDEO.COM \\
			// ------------------------------ \\

			1 =>
			[
			'regex' => '#\:noel\:#i',
			'usage' => ':noel:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/noel.gif').'"'
			],

			2 =>
			[
			'regex' => '#\:hap\:#i',
			'usage' => ':hap:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/hap.gif').'"'
			],

			3 =>
			[
			'regex' => '#\:-\)(?!\))#i', // REGEX PERMETTANT L'USAGE CORRECT DU SMILEY :-)))
			'usage' => ':-)',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:-).gif').'"'
			],

		    4 =>
			[
			'regex' => '#\:-\)\)\)#i',
			'usage' => ':-)))',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:-))).gif').'"'
			],

			5 =>
			[
			'regex' => '#\:-\(\(#i',
			'usage' => ':-((',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:-((.gif').'"'
			],

			6 =>
			[
			'regex' => '#\:-\((?!\()#i',
			'usage' => ':-(',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:-(.gif').'"'
			],

			7 =>
			[
			'regex' => '#\:\(#i',
			'usage' => ':(',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:(.gif').'"'
			],

			8 =>
			[
			'regex' => '#\:\)#i',
			'usage' => ':)',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:).gif').'"'
			],

			9 =>
			[
			'regex' => '#\:o\)\)#i',
			'usage' => ':o))',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:o)).gif').'"'
			],

			10 =>
			[
			'regex' => '#\:p\)#i',
			'usage' => ':p)',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/:p).gif').'"'
			],

			11 =>
			[
			'regex' => '#\:banzai\:#i',
			'usage' => ':banzai:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/banzai.gif').'"'
			],

			12 =>
			[
			'regex' => '#\:bave\:#i',
			'usage' => ':bave:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/bave.gif').'"'
			],

			13 =>
			[
			'regex' => '#\:bravo\:#i',
			'usage' => ':bravo:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/bravo.gif').'"'
			],

			14 =>
			[
			'regex' => '#\:bye\:#i',
			'usage' => ':bye:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/bye.gif').'"'
			],

			15 =>
			[
			'regex' => '#\:cd\:#i',
			'usage' => ':cd:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/cd.gif').'"'
			],

			16 =>
			[
			'regex' => '#\:cimer\:#i',
			'usage' => ':cimer:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/cimer.gif').'"'
			],

			17 =>
			[
			'regex' => '#\:coeur\:#i',
			'usage' => ':coeur:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/coeur.gif').'"'
			],

			18 =>
			[
			'regex' => '#\:content\:#i',
			'usage' => ':content:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/content.gif').'"'
			],

			19 =>
			[
			'regex' => '#\:cool\:#i',
			'usage' => ':cool:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/cool.gif').'"'
			],

			20 =>
			[
			'regex' => '#\:d\)#i',
			'usage' => ':d)',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/d.gif').'"'
			],

			21 =>
			[
			'regex' => '#\:g\)#i',
			'usage' => ':g)',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/g.gif').'"'
			],

			22 =>
			[
			'regex' => '#\:ddb\:#i',
			'usage' => ':ddb:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/ddb.gif').'"'
			],

			23 =>
			[
			'regex' => '#\:dehors\:#i',
			'usage' => ':dehors:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/dehors.gif').'"'
			],

			24 =>
			[
			'regex' => '#\:desole\:#i',
			'usage' => ':desole:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/desole.gif').'"'
			],

			25 =>
			[
			'regex' => '#\:diable\:#i',
			'usage' => ':diable:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/diable.gif').'"'
			],

			26 =>
			[
			'regex' => '#\:dpdr\:#i',
			'usage' => ':dpdr:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/dpdr.gif').'"'
			],

			27 =>
			[
			'regex' => '#\:fete\:#i',
			'usage' => ':fete:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/fete.gif').'"'
			],

			28 =>
			[
			'regex' => '#\:fier\:#i',
			'usage' => ':fier:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/fier.gif').'"'
			],

			29 =>
			[
			'regex' => '#\:fou\:#i',
			'usage' => ':fou:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/fou.gif').'"'
			],

			30 =>
			[
			'regex' => '#\:gba\:#i',
			'usage' => ':gba:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/gba.gif').'"'
			],

			31 =>
			[
			'regex' => '#\:gne\:#i',
			'usage' => ':gne:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/gne.gif').'"'
			],

			32 =>
			[
			'regex' => '#\:gni\:#i',
			'usage' => ':gni:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/gni.gif').'"'
			],

			33 =>
			[
			'regex' => '#\:hello\:#i',
			'usage' => ':hello:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/hello.gif').'"'
			],

			34 =>
			[
			'regex' => '#\:honte\:#i',
			'usage' => ':honte:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/honte.gif').'"'
			],

			35 =>
			[
			'regex' => '#\:hs\:#i',
			'usage' => ':hs:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/hs.gif').'"'
			],

			36 =>
			[
			'regex' => '#\:hum\:#i',
			'usage' => ':hum:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/hum.gif').'"'
			],

			37 =>
			[
			'regex' => '#\:lol\:#i',
			'usage' => ':lol:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/lol.gif').'"'
			],

			38 =>
			[
			'regex' => '#\:malade\:#i',
			'usage' => ':malade:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/malade.gif').'"'
			],

			39 =>
			[
			'regex' => '#\:merci\:#i',
			'usage' => ':merci:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/merci.gif').'"'
			],

			40 =>
			[
			'regex' => '#\:monoeil\:#i',
			'usage' => ':monoeil:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/monoeil.gif').'"'
			],

			41 =>
			[
			'regex' => '#\:mort\:#i',
			'usage' => ':mort:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/mort.gif').'"'
			],

			42 =>
			[
			'regex' => '#\:nah\:#i',
			'usage' => ':nah:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/nah.gif').'"'
			],

			43 =>
			[
			'regex' => '#\:non\:#i',
			'usage' => ':non:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/non.gif').'"'
			],

			44 =>
			[
			'regex' => '#\:non2\:#i',
			'usage' => ':non2:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/non2.gif').'"'
			],

			45 =>
			[
			'regex' => '#\:nonnon\:#i',
			'usage' => ':nonnon:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/nonnon.gif').'"'
			],

			46 =>
			[
			'regex' => '#\:objection\:#i',
			'usage' => ':objection:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/objection.gif').'"'
			],

			47 =>
			[
			'regex' => '#\:ok\:#i',
			'usage' => ':ok:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/ok.gif').'"'
			],

			48 =>
			[
			'regex' => '#\:ouch\:#i',
			'usage' => ':ouch:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/ouch.gif').'"'
			],

			49 =>
			[
			'regex' => '#\:ouch2\:#i',
			'usage' => ':ouch2:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/ouch2.gif').'"'
			],

			50 =>
			[
			'regex' => '#\:oui\:#i',
			'usage' => ':oui:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/oui.gif').'"'
			],

			51 =>
			[
			'regex' => '#\:pacd\:#i',
			'usage' => ':pacd:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/pacd.gif').'"'
			],

			52 =>
			[
			'regex' => '#\:pacg\:#i',
			'usage' => ':pacg:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/pacg.gif').'"'
			],

			53 =>
			[
			'regex' => '#\:pave\:#i',
			'usage' => ':pave:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/pave.gif').'"'
			],

			54 =>
			[
			'regex' => '#\:peur\:#i',
			'usage' => ':peur:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/peur.gif').'"'
			],

			55 =>
			[
			'regex' => '#\:pf\:#i',
			'usage' => ':pf:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/pf.gif').'"'
			],

			56 =>
			[
			'regex' => '#\:play\:#i',
			'usage' => ':play:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/play.gif').'"'
			],

			57 =>
			[
			'regex' => '#\:question\:#i',
			'usage' => ':question:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/question.gif').'"'
			],

			58 =>
			[
			'regex' => '#\:rechercher\:#i',
			'usage' => ':rechercher:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/rechercher.gif').'"'
			],

			59 =>
			[
			'regex' => '#\:rire\:#i',
			'usage' => ':rire:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/rire.gif').'"'
			],

			60 =>
			[
			'regex' => '#\:rire2\:#i',
			'usage' => ':rire2:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/rire2.gif').'"'
			],

			61 =>
			[
			'regex' => '#\:rouge\:#i',
			'usage' => ':rouge:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/rouge.gif').'"'
			],

			62 =>
			[
			'regex' => '#\:salut\:#i',
			'usage' => ':salut:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/salut.gif').'"'
			],

			63 =>
			[
			'regex' => '#\:sarcastic\:#i',
			'usage' => ':sarcastic:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/sarcastic.gif').'"'
			],

			64 =>
			[
			'regex' => '#\:siffle\:#i',
			'usage' => ':siffle:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/siffle.gif').'"'
			],

			65 =>
			[
			'regex' => '#\:sleep\:#i',
			'usage' => ':sleep:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/sleep.gif').'"'
			],

			66 =>
			[
			'regex' => '#\:snif\:#i',
			'usage' => ':snif:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/snif.gif').'"'
			],

			67 =>
			[
			'regex' => '#\:snif2\:#i',
			'usage' => ':snif2:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/snif2.gif').'"'
			],

			68 =>
			[
			'regex' => '#\:sors\:#i',
			'usage' => ':sors:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/sors.gif').'"'
			],

			69 =>
			[
			'regex' => '#\:sournois\:#i',
			'usage' => ':sournois:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/sournois.gif').'"'
			],

			70 =>
			[
			'regex' => '#\:spoiler\:#i',
			'usage' => ':spoiler:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/spoiler.gif').'"'
			],

			71 =>
			[
			'regex' => '#\:svp\:#i',
			'usage' => ':svp:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/svp.gif').'"'
			],

			72 =>
			[
			'regex' => '#\:up\:#i',
			'usage' => ':up:',
			'categorie' => 'jvc',
			'image' => '<img src="'.asset('smileys/rouge.gif').'"'
			],

			// ---------------------------- \\
			// FIN SMILEYS DE JEUXVIDEO.COM \\

			// DEBUT SMILEYS ANNEXE \\
			// -------------------- \\

			73 =>
			[
			'regex' => '#\:ari\:#i',
			'usage' => ':ari:',
			'categorie' => 'annexe',
			'image' => '<img src="'.asset('smileys/ari.gif').'"'
			],

			// ------------------ \\
			// FIN SMILEYS ANNEXE \\

			// DEBUT STICKERS \\
			// -------------- \\
			74 =>
			[
			'regex' => '#\:risitas1\:#i',
			'usage' => ':risitas1:',
			'categorie' => 'risitas',
			'image' => '<img src="'.asset('stickers/risitas1.png').'" height="60" width="80"'
			],

			75 =>
			[
			'regex' => '#\:risitas2\:#i',
			'usage' => ':risitas2:',
			'categorie' => 'risitas',
			'image' => '<img src="'.asset('stickers/risitas2.png').'" height="60" width="80"'
			],

			76 =>
			[
			'regex' => '#\:risitas3\:#i',
			'usage' => ':risitas3:',
			'categorie' => 'risitas',
			'image' => '<img src="'.asset('stickers/risitas3.png').'" height="60" width="80"'
			],
			// ------------ \\
			// FIN STICKERS \\
	    ]
	    ;

		return $smiley;
	}

	public function parse($messageToParse) {
		$smiley = Smiley::list(); // on récupère la liste des smileys qui est présent dans la fonction list() de cette présente classe.
		
		foreach($smiley as $smileys) {
			// IL FAUT LIMITER LES SMILEYS A 40 EFFICACEMENT, POUR L'INSTANT C'EST UNE LIMITE PAR SMILEY, C'EST PAS BON DU TOUS \\

			$messageToParse = preg_replace($smileys['regex'], $smileys['image'].'alt="'.$smileys['usage'].'">', $messageToParse, $this->smileyPerMessage);
		}

		return $messageToParse;
	}

	public function listing()
	{
		$smiley = Smiley::list();

		// CATEGORIE JEUXVIDEO.COM \\
		$liste = '<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><b>Jeuxvideo.com</b><br />'; // peut-être automatiser les catégories, mais flemme
		foreach($smiley as $smileys)
		{
			if($smileys['categorie'] == 'jvc') {
				$liste .= '<span type="button" onMouseOver="this.style.cursor=\'pointer\'" onclick="insertText(\'messageArea\', \''.$smileys['usage'].'\');" title="'.$smileys['usage'].'">'.$smileys['image'].'alt="'.$smileys['usage'].'">&nbsp;</span>';
			}
		}

		// CATEGORIE ANNEXE \\
		$liste .= '<hr /><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><b>Autre</b><br />';
		foreach($smiley as $smileys)
		{
			if($smileys['categorie'] == 'annexe') {
				$liste .= '<span type="button" onMouseOver="this.style.cursor=\'pointer\'" onclick="insertText(\'messageArea\', \''.$smileys['usage'].'\');" title="'.$smileys['usage'].'">'.$smileys['image'].'alt="'.$smileys['usage'].'">&nbsp;</span>';
			}
		}

		// CATEGORIE STICKERS \\
		$liste .= '<hr /><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><b>Risitas</b><br />';
		foreach($smiley as $smileys)
		{
			if($smileys['categorie'] == 'risitas') {
				$liste .= '<span type="button" onMouseOver="this.style.cursor=\'pointer\'" onclick="insertText(\'messageArea\', \''.$smileys['usage'].'\');" title="'.$smileys['usage'].'">'.$smileys['image'].'alt="'.$smileys['usage'].'">&nbsp;</span>';
			}
		}

		return $liste;
	}
}
