@extends('template.all')

@section('titre') {{ $sujet->find($id)->titre }} @endsection

@section('contenu')
<script src="{{ URL::asset('js/enable.js') }}"></script>
<script src="{{ URL::asset('js/insert.js') }}"></script>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default panel-sujet">
		@if(Auth::check() AND Auth::user()->level > 2 OR $isMod->exec())
		  <div class="panel-body">
			@if(Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
			<div class="pull-left">
				@if($sujet->find($id)->status == 2)
					<a href="{{ url('sujet/epingle/'.$id) }}" class="btn btn-sm btn-info" role="button">Désépingler</a>
				@elseif($sujet->find($id)->status == 1)
					<a href="{{ url('sujet/epingle/'.$id) }}" class="btn btn-sm btn-success" role="button">Épingler</a>
				@else
				{{-- Rien --}}
				@endif

				@if($sujet->find($id)->ouvert == 1)
					<a href="{{ url('sujet/verrouille/'.$id) }}" class="btn btn-sm btn-warning" role="button">Verrouiller</a>
				@else
					<a href="{{ url('sujet/verrouille/'.$id) }}" class="btn btn-sm btn-info" role="button">Déverrouiller</a>
				@endif
			</div>

			<div class="pull-right">
				@if($sujet->find($id)->status == 0)
					<a href="{{ url('sujet/delete/'.$id) }}" class="btn btn-sm btn-info" role="button">Restaurer</a>
				@else
					<a href="{{ url('sujet/delete/'.$id) }}" class="btn btn-sm btn-danger" role="button">Supprimer</a>
				@endif
			</div>
			@elseif($isMod->exec())
			<div class="pull-left">
				@if($sujet->find($id)->status == 2)
					<a href="{{ url('sujet/mod/epingle/'.$id) }}" class="btn btn-sm btn-info" role="button">Désépingler</a>
				@elseif($sujet->find($id)->status == 1)
					<a href="{{ url('sujet/mod/epingle/'.$id) }}" class="btn btn-sm btn-success" role="button">Épingler</a>
				@else
				{{-- Rien --}}
				@endif

				@if($sujet->find($id)->ouvert == 1)
					<a href="{{ url('sujet/mod/verrouille/'.$id) }}" class="btn btn-sm btn-warning" role="button">Verrouiller</a>
				@else
					<a href="{{ url('sujet/mod/verrouille/'.$id) }}" class="btn btn-sm btn-info" role="button">Déverrouiller</a>
				@endif
			</div>

			<div class="pull-right">
				@if($sujet->find($id)->status == 0)
					<a href="{{ url('sujet/mod/delete/'.$id) }}" class="btn btn-sm btn-info" role="button">Restaurer</a>
				@else
					<a href="{{ url('sujet/mod/delete/'.$id) }}" class="btn btn-sm btn-danger" role="button">Supprimer</a>
				@endif
			</div>
			@endif
			<br />
			<hr />
			</div>
			@endif

		{!! $design->pagination($id, $message) !!}

		<div class="panel-heading">
			<h3 class="panel-title wrap-text">
				<div class="pull-right"><a href="#formulaire"><span class="glyphicon glyphicon-circle-arrow-down glyphicon-clear" aria-hidden="true"></span></a></div>
				<a href="{{ url('forum/'.$forum_id.'/'.str_slug($forum->find($forum_id)->titre, '-')) }}" role="button"><span class="glyphicon glyphicon-circle-arrow-left glyphicon-clear" aria-hidden="true"></span></a> &nbsp;Sujet : {{ $sujet->find($id)->titre }}
			</h3>
		</div>
		@foreach($message as $messages)
			{!! $design->message($messages) !!}
		@endforeach
		<div class="panel-footer">
			<div class="pull-right"><a href="javascript:scroll(0,0)"><span class="glyphicon glyphicon-circle-arrow-up glyphicon-dark" style="font-size:16px;"aria-hidden="true"></span></a></div>
			<span class="glyphicon glyphicon-user" aria-hidden="true"></span> &nbsp;{!! $liste->online($id, 'sujet') !!}</div>
		</div>

		{!! $design->pagination($id, $message) !!}

		@if(session('citation'))
			{!! $design->form($bbcode, $smiley, $id, session('citation')) !!}
		@else
			{!! $design->form($bbcode, $smiley, $id) !!}
		@endif
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="smileys" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Liste des smileys</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<script src="{{ URL::asset('js/apercu.js') }}"></script>
<script>
	function reload() {
	    location.reload();
	}
</script>
@endsection
