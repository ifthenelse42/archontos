@extends('template.all')


@section('titre') Inscription @endsection

@section('contenu')
<div class="row">
	<div class="col-md-offset-3 col-md-6 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h3 class="panel-title">Formulaire d'inscription</h3>
			</div>
			<div class="panel-body">
				<p class="text-muted">
				Bienvenue dans le formulaire d'inscription de Lancta.
				<br />
				Vous pourrez vous connecter directement après vous êtres inscris.
				<br />
				Vous ne recevrez pas d'email de confirmation ni de validation.
				</p>
				<hr />
				<form action="{{ url('inscription') }}" method="POST" class="form-signin">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group">
						<label for="pseudo">Pseudonyme</label>
						<input type="text" name="pseudo" class="form-control" placeholder="Entre 2 et 15 caractères." value="{{ old('pseudo') }}"></input>
					</div>

					<div class="form-group">
						<label for="pseudo">Adresse email</label>
						<input type="email" name="email" class="form-control" placeholder="Adresse email valide" value="{{ old('email') }}"></input>
					</div>

					<div class="form-group">
						<label for="password">Mot de passe</label>
						<input type="password" name="password" class="form-control" placeholder="Votre mot de passe"></input>
					</div>

					<div class="form-group">
						<label for="password_confirmation">Confirmez</label>
						<input type="password" name="password_confirmation" class="form-control" placeholder="Confirmez le mot de passe"></input>
					</div>

					<div class="form-group">
						<label>
							<input type="checkbox" name="reglement"> j'ai lu et approuvé les <a href="{{ url('condition-generale-utilisation') }}" target="_blank">conditions générales d'utilisation de Lancta</a>
					    </label>
					</div>

					<div class="form-group">
						{!! app('captcha')->display(); !!}
					</div>

					<div class="text-center">
						<input class="btn btn-default" type="submit" value="S'inscrire">
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
