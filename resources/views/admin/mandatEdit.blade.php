@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Modifier un mandat de modération</h3><hr />
			<form action="{{ url('admin/moderation/mandat/edit/'.$moderation->id) }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<select class="form-control" name="forum">
						@foreach($forum as $forums)
							@if($forums->id == $moderation->forum_id)
								<option selected="selected" value="{{ $forums->id }}">{{ $forums->nom }}</option>
							@else
								<option value="{{ $forums->id }}">{{ $forums->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<label for="forum">Dates du mandat</label>
				<p class="text-muted">
					Les dates doivent être au format suivant : AAAA-MM-JJ<br />
					Les mandats prennent effet à partir de minuit ; si la date de début est aujourd'hui, il prendra effet immédiatement.<br />
					Lorsque "durée indéfinie" est coché, la case "Fin du mandat" n'est plus comptée.
				</p>
				<div class="form-group">
					<input type="text" name="mandat_debut" class="form-control" placeholder="Début du mandat" value="{{ $temps->date2($moderation->mandat_debut) }}"></input>
				</div>

				<div class="form-group">
					<input type="text" name="mandat_fin" class="form-control" placeholder="Fin du mandat" value="{{ $temps->date2($moderation->mandat_fin) }}"></input>
				</div>

				<div class="checkbox">
				  <label>
					<input type="checkbox" value="1" name="mandat_indefinie">
						Durée indéfinie
				  </label>
				</div>

				<div class="pull-left">
					<input class="btn btn-primary btn-block" type="submit" value="Valider">
				</div>
			</form>
		</div>
		@include('admin.menu')
	</div>
@endsection
