@extends('template.all')

{{-- Injection de la classe User utilisant la table utilisateurs --}}
@inject('utilisateurs', 'App\User')

@inject('HasViewed', 'App\Repository\Mp\HasViewed')
@inject('lastMsg', 'App\Repository\Mp\LastMsg')
@inject('temps', 'App\Repository\Temps\Temps')
@inject('nbReponses', 'App\Repository\Sujet\nbReponses')

@section('titre') Messages privés @endsection

@section('contenu')
<div class="row">

	<div class="col-md-8 col-xs">
		<h3>Messagerie privée</h3>
		<hr />
		<div class="wrap-mp">
			<div class="pull-left">
				<button class="btn btn-default" onclick="reload()">Actualiser</button>
			</div>

			<div class="pull-left visible-xs">
				<div class="dropdown">&nbsp;
				  <button class="btn btn-info dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Options
					<span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" aria-labelledby="options">
					<li><a href="{{ url('mp/vu/all') }}">Marquer tous comme lus</a></li>
					<li><a href="{{ url('mp/delete/all') }}">Quitter toute les conversations</a></li>
				  </ul>
				</div>
			</div>

			<div class="pull-right">
				<a href="{{ url('mp/new') }}" class="btn btn-success">Nouveau message</a>
			</div>

			<br /><hr />
			{!! $design->pagination(0, $mp_sujet, 'mp_sujet') !!}
		</div>
		@if($mp_participant->where('utilisateurs_id', Auth::user()->id)->count() > 0)

		<div class="list-group mp-list">
				@foreach($mp_sujet as $mps_sujets)
				<a href="{{ url('mp/'.$mps_sujets->id.'/'.str_slug($mps_sujets->titre, '-')) }}" class="list-group-item mp-titre @if($HasViewed->countNotKnown($mps_sujets->id) > 0) mp-non-lu @endif">
					<h4 class="list-group-item-heading">{{ $mps_sujets->titre }}</h4>
					<p class="list-group-item-text mp-infos">
						<div class="pull-left">{!! $identificate->pseudoWithLevel($mps_sujets->utilisateurs_id) !!}</div>
						<div class="pull-left">&nbsp;| {{ $temps->sujet($lastMsg->get($mps_sujets->id)->created_at) }}</div>
						<div class="pull-right">
							<strong>
								{{ $nbReponses->get($mps_sujets->id, 'mp') }}
							</strong>
						</div>
					</p>
				</a>
				@endforeach
		</div>
		{!! $design->pagination(0, $mp_sujet, 'mp_sujet') !!}
		@else
			<div class="alert alert-warning alert" role="alert">
				Vous n'avez aucun message.
			</div>
		@endif
	</div>

	<div class="col-md-4 hidden-xs">
		<div class="panel panel-default">
			<div class="panel-heading">Options</div>
			<div class="panel-body">
				<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> <a href="{{ url('mp/vu/all') }}">Marquer tous les messages comme lus</a><br />
				<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> <a href="{{ url('mp/delete/all') }}">Quitter toute les conversations</a>
			</div>
		</div>
	</div>
</div>
<script>
	function reload() {
	    location.reload();
	}
</script>
@endsection
