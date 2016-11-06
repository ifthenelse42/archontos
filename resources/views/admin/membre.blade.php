@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Gestion des membres</h3><hr />
			<p class="text-muted">
				Ici figure la liste TOTALE des membres du forum, classé par ID de la base de donnée.<br />
				<br />
				</p>
				<h4><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Coloration de la liste</h4>
				<hr />
				<p class="text-danger">Rouge : administrateur/webmaster</p>
				<p class="text-warning">Jaune : modérateur avec mandat actif ou non (sera rafraichis lors de sa prochaine connexion)</p>
				<p class="text-muted">Blanc : membre normal</p>
				<br />
				<h4><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Liste des membres</h4>
				<hr />
				<table class="table table-bordered table-striped table-adm">
				<tr>
					<th class="col-md-1">#</th>
					<th class="col-md-3">Pseudo</th>
					<th class="col-md-3">Ip à l'inscription</th>
					<th class="col-md-3">Date inscription</th>
					<th class="col-md-4">Action</th>
				</tr>

				@foreach($membre as $membres)
				@if($membres->level == 2) <tr class="warning">
				@elseif($membres->level >= 3) <tr class="danger">
				@else <tr>
				@endif
					<td>{{ $membres->id }}</td>
					<td>{{ $membres->pseudo }}</td>
					<td>{{ $membres->ip }}</td>
					<td>{{ $temps->date1($membres->created_at) }}</td>
					<td><div class="dropdown">
					  <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Options
						<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="options">
						<li class="dropdown-header">Fonctions d'administration</li>
						<li><a href="{{ url('admin/membre/promote/moderation/'.$membres->id) }}">Désigner comme modérateur</a></li>
						<li><a href="{{ url('admin/membre/ban/'.$membres->id) }}">@if($membres->level == 0) Débannir @else Bannir @endif</a></li>
						<li><a href="{{ url('admin/membre/empty/'.$membres->id) }}">Supprimer tous ses messages</a></li>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header">Fonctions de surveillance</li>
						<li class="disabled"><a href="#">Liste des adresses ip</a></li>
						<li class="disabled"><a href="#">Consulter ses informations</a></li>
						<li class="disabled"><a href="#">Visionner l'ensemble de ses messages</a></li>
						<li class="disabled"><a href="#">Traquer son activité</a></li>
						@if(Auth::user()->level == 4)
						<li role="separator" class="divider"></li>
						<li class="dropdown-header">Fonction unique au webmaster</li>
						<li><a href="{{ url('admin/membre/promote/admin/'.$membres->id) }}">@if($membres->level < 3) Promouvoir en tant qu'administrateur @else Rétrograder @endif</a></li>
						@endif
					  </ul>
					</div></td>
				</tr>
				@endforeach
				</table>
		</div>
		@include('admin.menu')
	</div>
@endsection
