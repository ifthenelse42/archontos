<form action="{{ url('compte') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="edit" value="profil">

	<div class="form-group">
		<textarea id="messageArea" placeholder="Votre présentation" class="form-control" rows="8" name="presentation">{{ $identificate->presentation(Auth::user()->id) }}</textarea>
	</div>

	<div class="checkbox">
		<label>
		@if($identificate->activity(Auth::user()->id) == 1)
			<input type="checkbox" name="activity" checked>
		@else
			<input type="checkbox" name="activity">
		@endif
			afficher publiquement le bloc activité
		</label>
	</div>

	<input class="btn btn-default" type="submit" value="Enregistrer">
</form>
