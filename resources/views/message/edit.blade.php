@extends('template.all')

@section('titre') Aperçu @endsection

@section('contenu')
<script src="{{ URL::asset('js/enable.js') }}"></script>
<script src="{{ URL::asset('js/insert.js') }}"></script>
<div class="row">
    <div class="col-md-offset-2 col-md-8 col-xs-12">
        <h4>Edition d'un message</h4>
        <hr />
			{!! $design->form($bbcode, $smiley, $id, 0, 'edit') !!}
    </div>
</div>
@endsection
