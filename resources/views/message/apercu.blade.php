@extends('template.all')

{{-- Injection de la classe User utilisant la table utilisateurs --}}
@inject('utilisateurs', 'App\User')
@inject('crypt', 'Crypt')

@inject('smiley', 'App\Repository\Message\Smiley')
@inject('temps', 'App\Repository\Temps\Temps')

@section('titre') Aperçu @endsection

@section('contenu')
	<div class="col-md-8">
		Test
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h3 class="panel-title">En-ligne</h3>
			</div>

			<div class="panel-body text-muted">
				En construction ...
			</div>
		</div>
	</div>
@endsection
