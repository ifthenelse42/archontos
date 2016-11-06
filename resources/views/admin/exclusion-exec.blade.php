@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Exclusion d'un membre</h3><hr />
			Vous êtes sur le point d'exclure le membre "<strong>{{ $identificate->pseudo($id) }}</strong>" pour le message suivant :
			<hr />
			<button class="btn btn-sm btn-warning" type="button" data-toggle="collapse" data-target="#collapseMessage" aria-expanded="false" aria-controls="collapseMessage">
			  Afficher le contenu du message
			</button>
			<div class="collapse" id="collapseMessage">
				<br />
				{{ $message->find($idMessage)->contenu }}
			</div>
			<hr />
			<form action="{{ url('admin/exclusion/'.$id.'/'.$idForum.'/'.$idMessage) }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="remain">Durée</label>
					<select class="form-control" name="type-remain">
						<option value="1">Heures</option>
						<option value="2">Jours</option>
						<option value="3">Mois</option>
						<option value="4">Années</option>
					</select>
				</div>

				<div class="form-group">
					<input type="text" name="remain" class="form-control" placeholder="Durée de l'exclusion" value="{{ old('remain') }}"></input>
				</div>

				<div class="checkbox">
				    <label>
				      <input type="checkbox" name="definitive" value="1"> Définitif
					</label>
				</div>
				<strong>Type de l'exclusion</strong>
				<div class="radio">
					<label>
						<input type="radio" name="type" value="1" checked> Uniquement du forum "{{ $forum->find($idForum)->nom }}"
					</label>
				</div>

				<div class="radio">
					<label>
						<input type="radio" name="type" value="2"> Global - aura accès au forum exil
					</label>
				</div>

				<div class="radio">
					<label>
						<input type="radio" name="type" value="3"> Verrouillage du compte
					</label>
				</div>

				<input class="btn btn-warning" type="submit" value="Valider">
			</form>
		</div>
		@include('admin.menu')
	</div>
@endsection
