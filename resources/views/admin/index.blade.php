@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Bienvenue {{ Auth::user()->pseudo }}.</h3><hr />
			<h4><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Statistiques du forum</h4><hr />
			<p class="text-muted">Ces statistiques prennent également en compte les membres bannis, les messages et les sujets supprimés qui ne sont visible que de l'administration.</p>
			<hr />
			<table class="table table-bordered">
				<tr>
					<th class="col-md-9">Statistiques</th>
					<th class="col-md-4">Valeur</th>
				</tr>

				<tr>
					<td>Nombre total de messages</td>
					<td>{{ $total_messages }}</td>
				</tr>

				<tr>
					<td>Nombre total de sujets</td>
					<td>{{ $total_sujets }}</td>
				</tr>

				<tr>
					<td>Nombre total de forums</td>
					<td>{{ $total_forum }}</td>
				</tr>

				<tr>
					<td>Nombre total d'utilisateurs</td>
					<td>{{ $total_utilisateurs }}</td>
				</tr>

				<tr>
					<td>Nombre total d'utilisateurs bannis</td>
					<td>{{ $total_banni }}</td>
				</tr>

				<tr>
					<td>Nombre total de modérateur</td>
					<td>{{ $total_moderateur }}</td>
				</tr>

				<tr>
					<td>Nombre total d'administrateur</td>
					<td>{{ $total_administrateur }}</td>
				</tr>

				<tr>
					<td>Nombre total de messages privés</td>
					<td>{{ $total_mp }}</td>
				</tr>

				<tr>
					<td>Nombre total de vus</td>
					<td>{{ $total_vu }}</td>
				</tr>
			</table>
		</div>

		@include('admin.menu')
	</div>
@endsection
