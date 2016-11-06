@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Gestion des catégories</h3>
			<hr />
			<p class="text-danger">Cette page sert à gérer les forums. C'est donc une page critique qu'il faut manipuler avec précaution.</p>
			<br />
			<h4><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Ajouter une catégorie</h4>
			<hr />
			<form action="{{ url('admin/categorie') }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="nom">Nom</label>
					<input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie"></input>
				</div>

				<strong>Type de catégorie</strong>
				<div class="radio">
					<label>
							<input type="radio" name="type" value="1" checked> Tous
					</label>
				</div>

				<div class="radio">
					<label>
							<input type="radio" name="type" value="3"> Modération
					</label>
				</div>

				<div class="radio">
					<label>
							<input type="radio" name="type" value="2"> Connectés uniquement
					</label>
				</div>

				<div class="radio">
					<label>
							<input type="radio" name="type" value="0"> Exil
					</label>
				</div>

				<input class="btn btn-default" type="submit" value="Valider">
			</form>
			<br />
			<h4><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Liste des catégories</h4>
			<hr />
			<table class="table table-bordered table-striped table-adm">
				<tr>
					<th class="col-md-1">#</th>
					<th class="col-md-3">Nom</th>
					<th class="col-md-3">Date création</th>
					<th class="col-md-1">Action</th>
				</tr>

				@foreach($categorie->get() as $categories)
				<tr>
					<td>{{ $categories->id }}</td>
					<td>{{ $categories->nom }}</td>
					<td>{{ $temps->date1($categories->created_at) }}</td>
					<td><div class="dropdown">
					  <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Options
						<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="options">
						<li class="dropdown-header">Fonctions d'administration</li>
						<li><a href="{{ url('admin/categorie/edit/'.$categories->id) }}">Modifier cette catégorie</a></li>
						<li><a href="{{ url('admin/categorie/delete/'.$categories->id) }}">Supprimer cette catégorie</a></li>
						<li><a href="{{ url('admin/categorie/empty/'.$categories->id) }}">Vider la catégorie de ses forums</a></li>
					  </ul>
					</div></td>
				</tr>
				@endforeach
			</table>

			<h3>Gestion des forums</h3><hr />
			<h4><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Ajouter un forum</h4>
			<hr />
			<form action="{{ url('admin/forum') }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="categorie">Catégorie</label>
					<select class="form-control" name="categorie">
						@foreach($categorie->get() as $categories)
							<option value="{{ $categories->id }}">{{ $categories->nom }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="titre">Titre</label>
					<input type="text" name="nom" class="form-control" placeholder="Nom du forum"></input>
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" class="form-control" placeholder="Description du forum" rows="3"></textarea>
				</div>
				<input class="btn btn-default" type="submit" value="Valider">
			</form>
			<br />
			<h4><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Liste des forums</h4>
			<hr />
			<table class="table table-bordered table-striped table-adm">
				<tr>
					<th class="col-md-1">#</th>
					<th class="col-md-3">Catégorie</th>
					<th class="col-md-3">Titre</th>
					<th class="col-md-3">Description</th>
					<th class="col-md-3">Modérateur(s)</th>
					<th class="col-md-3">Date création</th>
					<th class="col-md-1">Action</th>
				</tr>

				@foreach($forum as $forums)
				<tr>
					<td>{{ $forums->id }}</td>
					<td>{{ $categorie->find($forums->categorie_id)->nom }}</td>
					<td>{{ $forums->nom }}</td>
					<td>{{ $forums->description }}</td>
					<td>Non disponible</td>
					<td>{{ $temps->date1($forums->created_at) }}</td>
					<td><div class="dropdown">
					  <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Options
						<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="options">
						<li class="dropdown-header">Fonctions d'administration</li>
						<li><a href="{{ url('admin/forum/edit/'.$forums->id) }}">Modifier ce forum</a></li>
						<li><a href="{{ url('admin/forum/delete/'.$forums->id) }}">Supprimer ce forum</a></li>
						<li><a href="{{ url('admin/forum/empty/'.$forums->id) }}">Vider le forum</a></li>
					  </ul>
					</div></td>
				</tr>
				@endforeach
			</table>
		</div>
		@include('admin.menu')
	</div>
@endsection
