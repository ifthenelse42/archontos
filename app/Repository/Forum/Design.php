<?php

namespace App\Repository\Forum;

use Auth;
use Request;

use App\Message;
use App\Forum;
use App\Moderation;
use App\Message_historique;

use App\Repository\Utilisateurs\Identificate;
use App\Repository\Temps\Temps;
use App\Repository\Message\Smiley;
use App\Repository\Message\Bbcode;
use App\Repository\Message\Find;
use App\Repository\Message\Edit;
use App\Repository\Mp\HasViewed;

use App\Repository\Moderation\isMod;
use App\Repository\Sujet\LastMsg;
use App\Repository\Message\Status;


class Design
{
	private $tempsEdit = 1; // temps en minutes dans laquelle un membre peut modifier son message. Est ignoré si c'est le premier message du sujet OU que c'est un modérateur ou administrateur.
	public function message($data, $location = 'sujet')
	{
		// Déclaration des classes nécessaire aux messages
		$identificate = new Identificate;
		$message_historique = new Message_historique;
		$temps = new Temps;
		$smiley = new Smiley;
		$find = new Find;
		$status = new Status;
		$bbcode = new Bbcode;
		$design = new Design;
		$hasViewed = new HasViewed;
		$isMod = new isMod;
		$editFunction = new Edit;

		if($location == 'sujet') // si le message est dans un sujet
		{
			if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
			{
				if($data->status == 0)
				{
					$delete = '<li><a href="'.url('message/delete/'.$data->id).'">Restaurer</a></li>';
				}

				else
				{
					$delete = '<li><a href="'.url('message/delete/'.$data->id).'">Supprimer</a></li>';
				}

				if($identificate->getLevel($data->utilisateurs_id) == 0)
				{
					$expulse = '<li><a href="'.url('admin/exclusion').'">Gestion des expulsions</a></li>';
				}

				else
				{
					$expulse = '<li><a href="'.url('admin/exclusion/'.$data->utilisateurs_id.'/'.$data->sujet->forum->id.'/'.$data->id).'">Expulser</a></li>';
				}

				$edit = '<li><a href="'.url('message/edit/'.$data->id).'">Modifier</a></li>';
				$historique = '<li><a href="'.url('message/historique/'.$data->id).'">Historique</a></li>';

				$left = '<div class="dropup">
					<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Options
					<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="options">
						'.$edit.'
						'.$historique.'
						'.$delete.'
						<li role="separator" class="divider"></li>
						'.$expulse.'
						</ul>
					</div>';
			}

			elseif($isMod->exec()) // MODERATEUR
			{
				if($data->status == 0)
				{
					$delete = '<li><a href="'.url('message/mod/delete/'.$data->id).'">Restaurer</a></li>';
				}

				else
				{
					$delete = '<li><a href="'.url('message/mod/delete/'.$data->id).'">Supprimer</a></li>';
				}

				if($identificate->getLevel($data->utilisateurs_id) < 3)
				{
					$expulse = '<li role="separator" class="divider"></li><li><a href="'.url('moderation/exclusion/'.$data->utilisateurs_id.'/'.$data->sujet->forum->id.'/'.$data->id).'">Expulser</a></li>';
				} else { $expulse = ''; }

				$edit = '<li><a href="'.url('message/edit/'.$data->id).'">Modifier</a></li>';

				$left = '<div class="dropup">
					<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Options
					<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="options">
					'.$edit.'
					'.$delete.'
					'.$expulse.'
					</ul>
					</div>';
			}

			else
			{
				$left = '';
			}

			$numberGet = '<a href="'.url('#message_'.$find->number($data->id)).'"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> '.$find->number($data->id).'</a>';

			$number = $find->number($data->id);
		}

		elseif($location == 'mp') // si le message est dans un message privé
		{
			$left = $hasViewed->get($data->id, $data->utilisateurs_id);

			$numberGet = '<a href="'.url('#message_'.$find->number($data->id, 'mp')).'"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> '.$find->number($data->id, 'mp').'</a>';

			$number = $find->number($data->id, 'mp');
		}

		if(Auth::check())
		{
			if($data->utilisateurs_id == Auth::user()->id) { // si ce message appartiens au membre lambda, alors ...
				if(Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE) {
					if($data->status == 0)
					{
						$delete = '<li><a href="'.url('message/delete/'.$data->id).'">Restaurer</a></li>';
					}

					else
					{
						$delete = '<li><a href="'.url('message/delete/'.$data->id).'">Supprimer</a></li>';
					}

					$edit = '<li><a href="'.url('message/edit/'.$data->id).'">Modifier</a></li>';
					$historique = '<li><a href="'.url('message/historique/'.$data->id).'">Historique</a></li>';
				} else {
					if($editFunction->isAble($data->id)) {
						$edit = '<li><a href="'.url('message/edit/'.$data->id).'">Modifier</a></li>';

					} else {
						$edit = '<li class="disabled"><a>Modifier</a></li>';
					}

					$delete = '';
					$historique = '';
				}



				$left = '<div class="dropup">
					<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Options
					<span class="caret"></span>
					</button>
						<ul class="dropdown-menu" aria-labelledby="options">
							'.$edit.'
							'.$historique.'
							'.$delete.'
						</ul>
					</div>';
			}

			if($location == 'sujet') {
				$bottom = '
				<th class="none hidden-xs"></th>
				<th class="right-bottom">
					<div class="pull-left text-muted">
						'.$left.'
					</div>

					<div class="pull-right">
						'.$design->answer($smiley, $data, $bbcode, $identificate).'
					</div>
				</th>';
			} elseif($location == 'mp') {
				$bottom = '
				<th class="none hidden-xs"></th>
				<th class="right-bottom">
					<div class="pull-left text-muted">
						'.$left.'
					</div>

					<div class="pull-right">

					</div>
				</th>';
			}

		}

		else
		{
			$bottom = '';
		}

		if(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
		{
			if($data->anonymous == 1)
			{
				$pseudo = $identificate->pseudoWithLevel($data->utilisateurs_id);
				$level = '<i>Anonyme</i>';
				$avatar = $identificate->avatar($data->utilisateurs_id);
				$infos =
				$identificate->online($data->utilisateurs_id).'<br />'
				.$identificate->anciennete($data->utilisateurs_id).'<br />'.$identificate->nbMessage($data->utilisateurs_id);
			}

			else
			{
				if($location == 'mp') {
					$pseudo = $identificate->pseudoWithLevel($data->utilisateurs_id, 0);
					$level = $identificate->level($data->utilisateurs_id);
				} else {
					$pseudo = $identificate->pseudoWithLevel($data->utilisateurs_id, 0, $data->sujet->forum->id);
					$level = $identificate->level($data->utilisateurs_id, $data->sujet->forum->id);
				}
				$avatar = $identificate->avatar($data->utilisateurs_id);
				$infos =
				$identificate->online($data->utilisateurs_id).'<br />'
				.$identificate->anciennete($data->utilisateurs_id).'<br />'.$identificate->nbMessage($data->utilisateurs_id);
			}
		}

		elseif($data->anonymous == 1)
		{
			$pseudo = $identificate->pseudoWithLevel($data->utilisateurs_id, 1);
			$level = '';
			$avatar = $identificate->avatar($data->utilisateurs_id, 1);
			$infos = '';
		}

		else
		{
			if($location == 'mp') {
				$pseudo = $identificate->pseudoWithLevel($data->utilisateurs_id, 0);
				$level = $identificate->level($data->utilisateurs_id);
			} else {
				$pseudo = $identificate->pseudoWithLevel($data->utilisateurs_id, 0, $data->sujet->forum->id);
				$level = $identificate->level($data->utilisateurs_id, $data->sujet->forum->id);
			}

			$avatar = $identificate->avatar($data->utilisateurs_id);
			$infos =
			$identificate->online($data->utilisateurs_id).'<br />'
			.$identificate->anciennete($data->utilisateurs_id).'<br />'.$identificate->nbMessage($data->utilisateurs_id);
		}

		if($message_historique->where('message_id', $data->id)->count() > 1) { // supérieur à 1 car on ne compte pas le message originel
			if($location == 'mp') {
				$date_edit = '';
				$edited = '';
			} else {
				$date_edit = $message_historique->where('message_id', $data->id)->orderBy('id', 'DESC')->first()->created_at;
				$edited = '<i> - modifié '.$temps->message($date_edit).'</i>';
			}
		} else {
			$edited = '';
		}

		$message = '<a name="message_'.$number.'"></a><div class="'.$status->get($data->status).'">
			<table class="table-message">
			<tr>
			<th class="text-center hidden-xs pseudo left-top">'.$pseudo.'</th>
			<th class="right-top">
			<div class="pull-left"><span class="visible-xs pseudo-xs"><img src="'.$avatar.'" class="img-avatar-xs" alt="?" /> '.$pseudo.'</span>'.$temps->message($data->created_at).''.$edited.'</div>
			<div class="pull-right">
			'.$numberGet.'
			</div>
			</th>
			</tr>

			<tr>
			<td class="left col-align-top hidden-xs">
			<div class="titre text-center">'.$level.'</div>
			<p class="text-center info">
			<img src="'.$avatar.'" class="img-rounded img-avatar" alt="Avatar" />
			<br />'.$infos.'
			</p>
			</td>

			<td class="col-lg right-middle wrap-text">'.$smiley->parse($bbcode->get(nl2br(e($data->contenu)))).'</td>
			</tr>
			<tr>
			'.$bottom.'
			</tr>
			</table>
			</div>';

			return $message;
	}

	public function form($bbcode, $smiley, $id, $citation = 0, $location = 'sujet')
	{
		if(Auth::check())
		{
			$identificate = new Identificate;

			$titre_form = ''; // variable changée uniquement si on est dans la page d'un forum ou dans la création d'un MP
			$destinataire = ''; // variable changée uniquement si on est dans la page d'un forum

			if($location == 'sujet')
			{
				$titre = '<br /><br />';
				$action = url('sujet/'.$id);
			}

			elseif($location == 'edit')
			{
				$titre = '';
				$action = url('message/edit/'.$id);
			}

			elseif($location == 'forum')
			{
				$titre = '<br /><br />';
				$titre_form = '<div class="form-group">
					<input type="text" name="titre" placeholder="Titre du sujet" class="form-control titre" value="'.e(old('titre')).'"></input>
					</div>';
			$action = url('forum/'.$id);
			}

			elseif($location == 'mp')
			{
				$titre = '';
				$action = url('mp/'.$id);
			}

			elseif($location == 'mp_new')
			{
				$titre = '<h4 class="titre-message-area"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> Rédiger un message privé</h4>';
				$titre_form = '<div class="form-group">
					<input type="text" name="titre" placeholder="Titre du message" class="form-control titre" value="'.e(old('titre')).'"></input>
					</div>';
			$destinataire = '<div class="form-group">
				<input type="text" name="destinataire" placeholder="Pseudo du destinataire" class="form-control titre" value="'.e(old('destinataire')).'"></input>
				</div>';
			$action = url('mp/new');
			}

			if($citation > 0 && empty(e(old('contenu')))) {
				if(Message::find($citation)->anonymous == 1) {
					$pseudoCitation = 'Anonyme';
				} else { $pseudoCitation = $identificate->pseudo(Message::find($citation)->utilisateurs_id); }
				$message = Message::find($citation)->contenu;
				$contenu = '[citation]Message de '.$pseudoCitation.' :

'.$message.'[/citation]

';
			} elseif($location == 'edit') {
				$contenu = e(Message::find($id)->contenu);
			} else {
				$contenu = e(old('contenu'));
			}

			$formulaire = $titre.'
			<a name="formulaire"></a>
			<form action="'.$action.'" method="POST">
				<input type="hidden" name="_token" value="'.csrf_token().'">
				<div class="message-area">
					'.$destinataire.'
					'.$titre_form.'
					<div class="form-group">
						<div class="pull-left">
						<div class="bbcode">'.$bbcode->buttons().'</div></div>
						<div class="pull-right">'.$bbcode->smiley_liste().'</div>
						<textarea id="messageArea" placeholder="Votre message" class="form-control" rows="8" name="contenu">'.$contenu.'</textarea>
					</div>

					<div class="pull-right">
						<input class="btn btn-sm btn-primary" type="submit" value="Envoyer">
					</div>

					<div class="pull-left">
						<button type="button" class="btn btn-sm btn-default inactive">Aperçu</button>
					</div>
				</div>
			</form>';
		} else {
			$formulaire = '';
		}

		return $formulaire;
	}

	public function answer($smiley, $messages, $bbcode, $identificate, $location = 'sujet')
	{
		$contenu = e($messages->contenu);
		$find = new Find;
		if($location == 'sujet') {
			$button =
			'
			<form action="/message/citation/'.$messages->id.'" method="POST">
				<input type="hidden" name="_token" value="'.csrf_token().'">
					<input type="hidden" name="id" value="'.$messages->id.'"/>
					<input class="btn btn-xs btn-default" type="submit" value="Répondre">
			</form>
			';
		} else { $button = ''; }

		return $button;
	}

	public function pagination($id, $pagination, $location = 'sujet')
	{
		$separate = 5;

		$liste = '';
		$liste .= '<div class="page-wrap">';

		if($location == 'sujet')
		{
			$lien = 'sujet'.'/'.$id.'/'.Request::segment(3);
		}

		elseif($location == 'mp')
		{
			$lien = 'mp'.'/'.$id.'/'.Request::segment(3);
		}

		elseif($location == 'mp_sujet')
		{
			$lien = 'mp'; // il est le seul où rien ne suis le liens
		}

		elseif($location == 'forum')
		{
			$lien = 'forum'.'/'.$id.'/'.Request::segment(3);
		}

		if($pagination->lastPage() > 1)
		{
			$liste .= '<div class="pull-right page">';

			if($pagination->currentPage() > 2)
			{
				$liste .= '<a href="'.url($lien).'"><span class="glyphicon glyphicon-step-backward glyphicon-page" aria-hidden="true"></span></a>';
			}

			elseif($pagination->currentPage() == 2)
			{
				$liste .= '<a href="'.url($lien).'"><span class="glyphicon glyphicon-backward glyphicon-page" aria-hidden="true"></span></a>';
			}

			if($pagination->currentPage() > 2)
			{
				$liste .= '<a href="'.$pagination->previousPageUrl().'"><span class="glyphicon glyphicon-backward glyphicon-page" aria-hidden="true"></span></a>';
			}

			for($count = $pagination->currentPage() - $separate; $count < $pagination->currentPage(); $count++)
			{
				if($count == 1 && $count != $pagination->currentPage())
				{
					$liste .= '<a href="'.url($lien).'" class="url">'.$count.'</a>';
				}

				elseif($count >= 1)
				{
					$liste .= '<a href="'.$pagination->url($count).'" class="url">'.$count.'</a>';
				}

				else
				{
					$count = '';
				}
			}

			for ($count = $pagination->currentPage(); $count < $pagination->currentPage() + $separate; $count++)
			{
				if($count == 1 && $count != $pagination->currentPage())
				{
					$liste .= '<a href="'.url($lien).'" class="url">'.$count.'</a>';
				}

				elseif($count == $pagination->currentPage())
				{
					$liste .= '<a class="url active">'.$count.'</a>';
				}

				elseif($count <= $pagination->lastPage())
				{
					$liste .= '<a href="'.$pagination->url($count).'" class="url">'.$count.'</a>';
				}

				else
				{
					break;
				}
			}

			if($pagination->hasMorePages())
			{
				$liste .= '<a href="'.$pagination->nextPageUrl().'"><span class="glyphicon glyphicon-forward glyphicon-page" aria-hidden="true"></span></a>';
			}

			if($pagination->currentPage() + 1 < $pagination->lastPage())
			{
				$liste .= '<a href="'.url(url($lien).'?page='.$pagination->lastPage()).'"><span class="glyphicon glyphicon-step-forward glyphicon-page" aria-hidden="true"></span></a>';
			}

			$liste .= '</div>';
		}

		$liste .= '</div>';
		return $liste;
	}
}
