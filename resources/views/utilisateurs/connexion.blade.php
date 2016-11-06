@extends('template.all')


@section('titre') Connexion @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-offset-4 col-md-4 col-xs-10 col-xs-offset-1">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Connexion</h3>
			  </div>
		<div class="panel-body">
			<form action="{{ url('connexion') }}" method="POST" class="form-signin">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="pseudo" class="sr-only">Votre pseudo</label>
					<input type="text" name="pseudo" class="form-control" placeholder="Pseudo" value="{{ old('pseudo') }}"></input>
				</div>

				<div class="form-group">
					<label for="password" class="sr-only">Votre mot de passe</label>
					<input type="password" name="password" class="form-control" placeholder="Mot de passe"></input>
				</div>

				<div class="checkbox">
				    <label>
				      <input type="checkbox" name="stay"> Rester en ligne
					</label>
				</div>

				<div class="text-center">
					<input class="btn btn-default" type="submit" value="Se connecter">
				</div>
			</form>
		</div>
	</div>
</div>
</div>
@endsection
