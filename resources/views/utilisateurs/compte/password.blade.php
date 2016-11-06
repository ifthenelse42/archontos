<form action="{{ url('compte') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="edit" value="password">

	<div class="form-group">
		<input type="password" name="password_old" class="form-control" placeholder="Mot de passe actuel" />
	</div>

	<div class="form-group">
		<input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" />
	</div>

	<div class="form-group">
		<input type="password" name="password_confirmation" class="form-control" placeholder="Confirmez" />
	</div>

	<input class="btn btn-default" type="submit" value="Enregistrer">
</form>
