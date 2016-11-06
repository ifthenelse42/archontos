@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Modifier des catégories</h3><hr />
			<form action="{{ url('admin/categorie/edit/'.$id) }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="nom">Nom</label>
					<input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie" value="{{ $categorie->nom }}"></input>
				</div>

				<strong>Type de catégorie</strong>
				<div class="radio">
					<label>
						@if($categorie->type == 1)
							<input type="radio" name="type" value="1" checked> Tous
						@else
							<input type="radio" name="type" value="1"> Tous
						@endif
					</label>
				</div>

				<div class="radio">
					<label>
						@if($categorie->type == 3)
							<input type="radio" name="type" value="3" checked> Modération
						@else
							<input type="radio" name="type" value="3"> Modération
						@endif
					</label>
				</div>

				<div class="radio">
					<label>
						@if($categorie->type == 2)
							<input type="radio" name="type" value="2" checked> Connectés uniquement
						@else
							<input type="radio" name="type" value="2"> Connectés uniquement
						@endif
					</label>
				</div>

				<div class="radio">
					<label>
						@if($categorie->type == 0)
							<input type="radio" name="type" value="0" checked> Exil
						@else
							<input type="radio" name="type" value="0"> Exil
						@endif
					</label>
				</div>

				<input class="btn btn-default" type="submit" value="Valider">
			</form>
		</div>
		@include('admin.menu')
	</div>
@endsection
