@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Désigner un modérateur</h3><hr />
			<p class="text-muted">Vous êtes sur le point de désigner "<strong>{{ $identificate->pseudo($id) }}</strong>" comme modérateur. Cela lui accordera le droit de supprimer, modifier des messages, expulser des membres du forum, et il sera vu par la communauté comme un dirigeant.<br />
			<br />
			Pour procéder à cela, vous devez lui désigner une clé de déverroillage qui lui servira à déverrouiller ses droits à chaque fois qu'il se connectera. Il vous faudra ensuite choisir le premier forum qu'il modérera et la durée du mandat.<br />
			<br />
			La clé de déverrouillage doit être gardé précieusement, car il ne peut pas être modifié ni consulté.</p>
			<hr >
			<form action="{{ url('admin/membre/promote/moderation/'.$id) }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<label for="secret_password">Clé de déverrouillage</label>
				<div class="form-group">
					<input type="password" name="secret_password" class="form-control" placeholder="Clé de déverrouillage"></input>
				</div>

				<div class="form-group">
					<select class="form-control" name="forum">
						@foreach($forum as $forums)
					  		<option value="{{ $forums->id }}">{{ $forums->nom }}</option>
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
					<input type="text" name="mandat_debut" class="form-control" placeholder="Début du mandat"></input>
            	</div>

				<div class="form-group">
					<input type="text" name="mandat_fin" class="form-control" placeholder="Fin du mandat"></input>
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
