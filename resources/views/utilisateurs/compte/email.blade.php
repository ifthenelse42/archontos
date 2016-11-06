<form action="{{ url('compte') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="edit" value="email">

	<div class="form-group">
		<p class="text-muted">Aucun email ne vous sera envoyé.</p>
		<input type="email" name="email" class="form-control" placeholder="Adresse email valide" value="{{ $identificate->email(Auth::user()->id) }}" />
	</div>

	<input class="btn btn-default" type="submit" value="Enregistrer">
</form>
