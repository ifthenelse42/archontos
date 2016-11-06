<form action="{{ url('compte') }}" method="POST" enctype="multipart/form-data" action="image">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="edit" value="avatar">

	<div class="form-group">
		<input type="file" id="avatar" name="avatar">
		<p class="help-block">
			Format : PNG, JPG, JPEG, GIF ou SVG
			<br />
			Poid maximum : 2 Mo
			<br />
			Largeur/hauteur minimale : 80x80
			<br />
			Le nouvel avatar mettra environs deux heures à s'afficher.
		</p>
	</div>

	<input class="btn btn-default" type="submit" value="Enregistrer">
</form>
