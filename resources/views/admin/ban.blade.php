@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Gestion des bannissements</h3><hr />
			<p class="text-muted">
				Cette page est inutile tant qu'un système de bannissement avancé n'aura pas été fait.
			</p>
		</div>
		@include('admin.menu')
	</div>
@endsection
