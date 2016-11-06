@extends('template.all')

{{-- Injection de la classe User utilisant la table utilisateurs --}}
@inject('utilisateurs', 'App\User')

@section('titre') Nouveau message privé @endsection

@section('contenu')
<script src="{{ URL::asset('js/enable.js') }}"></script>
<script src="{{ URL::asset('js/insert.js') }}"></script>

<div class="row">
	<div class="col-md-12">
		@if(isset($id))
			{!! $design->form($bbcode, $smiley, $id, 0, 'mp_new') !!}
		@else
			{!! $design->form($bbcode, $smiley, 0, 0, 'mp_new') !!}
		@endif

	</div>
</div>
@endsection
