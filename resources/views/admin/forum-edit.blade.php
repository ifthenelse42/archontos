@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Modification de forums</h3><hr />
			<form action="{{ url('admin/forum/edit/'.$forum->id) }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="categorie">Catégorie</label>
					<select class="form-control" name="categorie">
						@foreach($categorie as $categories)
							@if($categories->id == $forum->categorie_id)
								<option selected="selected" value="{{ $categories->id }}">{{ $categories->nom }}</option>
							@else
								<option value="{{ $categories->id }}">{{ $categories->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="titre">Titre</label>
					<input type="text" name="nom" class="form-control" placeholder="Titre du forum" value="{{ $forum->nom }}"></input>
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" class="form-control" placeholder="Description du forum" rows="3">{{ $forum->description }}</textarea>
				</div>

				<input class="btn btn-default" type="submit" value="Valider">
			</form>
		</div>
		@include('admin.menu')
	</div>
@endsection
