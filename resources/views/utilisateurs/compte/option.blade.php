<form action="{{ url('compte') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="edit" value="options">

	<div class="checkbox">
		<label>
		@if($identificate->invisible(Auth::user()->id) == 1)
			<input type="checkbox" name="invisible" checked>
		@else
			<input type="checkbox" name="invisible">
		@endif
			ne pas apparaître dans la liste des connectés
		</label>
	</div>

	<div class="checkbox">
		<label>
		@if($identificate->anonymous(Auth::user()->id) == 1)
			<input type="checkbox" name="anonymous" checked>
		@else
			<input type="checkbox" name="anonymous">
		@endif
			être anonyme
			<p class="text-muted">Cette option masquera votre pseudo et profil dans vos prochains messages.<br />Votre pseudo ne sera visible que de l'équipe de modération.</p>
		</label>
	</div>

	<input class="btn btn-default" type="submit" value="Enregistrer">
</form>
