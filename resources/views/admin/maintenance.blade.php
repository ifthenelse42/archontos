@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Maintenance de archontos</h3><hr />
			<p class="text-danger">La plupart des fonctions de maintenance sont disponible uniquement au webmaster. Cette page est à manipuler avec EXTRÊME précaution.</p>
			<br />
			<h4>Options de maintenance</h4>
			<hr />
			<p class="text-muted">Il n'y a aucune option de maintenance pour l'instant.</p>
		</div>
		@include('admin.menu')
	</div>
@endsection
