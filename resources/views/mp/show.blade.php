@extends('template.all')

{{-- Injection de la classe User utilisant la table utilisateurs --}}
@inject('utilisateurs', 'App\User')
@inject('crypt', 'Crypt')

@inject('smiley', 'App\Repository\Message\Smiley')
@inject('temps', 'App\Repository\Temps\Temps')

@section('titre') Message privé @endsection

@section('contenu')
	<script src="{{ URL::asset('js/enable.js') }}"></script>
	<script src="{{ URL::asset('js/insert.js') }}"></script>

	<div class="row">
		<div class="col-md">
			<div class="panel panel-default panel-sujet">
				<div class="panel-heading">
					<h3 class="panel-title">Sujet privé n°{{ $id }}</h3>

				</div>

				<div class="panel-body">
					<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Participant(s) :<br />
					@foreach($mp_participants as $mps_participants)
						{!! $identificate->pseudoWithLevel($mps_participants->utilisateurs_id) !!} @if($mps_participants->utilisateurs_id != $idAuteur && $idAuteur == Auth::user()->id) - <a href="{{ url('mp/'.$id.'/delete/participant/'.$mps_participants->utilisateurs_id) }}">supprimer</a>@endif
						<br />
					@endforeach
					@if($idAuteur == Auth::user()->id)
					<hr />
					<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Ajouter un participant :<br />
					<br />
					{{ Form::open(['url' => 'mp/'.$id.'/add/participant']) }}
						<div class="form-group">
							{{ Form::text('pseudo', null, ['placeholder' => "Pseudo du nouveau participant", 'class' => 'form-control']) }}
						</div>

						{!! Form::submit('Ajouter', ['class' => 'btn btn-sm btn-primary']) !!}
					{{ Form::close() }}
					@endif
				</div>
			</div>
		</div>
		<br />
		<div class="panel panel-default panel-sujet">
		<div class="panel-heading">
			<h3 class="panel-title wrap-text">
				<div class="pull-right"><a href="{{ url('mp/'.$id.'/leave/participant') }}" title="Quitter la conversation"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a> <span class="glyphicon glyphicon-refresh" aria-hidden="true" style="cursor: pointer;" onclick="reload()"></span> <a href="#formulaire"><span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span></a></div>
				<a href="{{ url('mp') }}" role="button"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span></a> &nbsp;{{ $mp_sujet_data->find($id)->titre }}
			</h3>
		</div>

		{!! $design->pagination($id, $mp, 'mp') !!}

		@foreach($mp as $mps)
		{{ $hasViewed->add($mps->id) }}
			{!! $design->message($mps, 'mp') !!}
		@endforeach

		<div class="panel-footer">
			<div class="pull-right"><a href="javascript:scroll(0,0)"><span class="glyphicon glyphicon-circle-arrow-up" style="font-size:16px;"aria-hidden="true"></span></a></div>&nbsp;</div>
		</div>

		{!! $design->pagination($id, $mp, 'mp') !!}

		<br />
		{!! $design->form($bbcode, $smiley, $id, 0, 'mp') !!}
	</div>
</div>

<script>
	function reload() {
	    location.reload();
	}
</script>
@endsection
