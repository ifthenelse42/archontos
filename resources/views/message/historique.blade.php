@extends('template.all')

@section('titre') Historique de message @endsection

@section('contenu')
<script src="{{ URL::asset('js/enable.js') }}"></script>
<script src="{{ URL::asset('js/insert.js') }}"></script>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <h4><a href="{{ $find->url($id, 'sujet') }}"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span></a> Historique du message n°{{ $id }}</h4>
        <hr />
        <?php $count = 1; ?>
        @foreach($message_historique as $messages)
            @if($count > 1)
                modifié par {!! $identificate->pseudoWithLevel($messages->utilisateurs_id, 0, $messages->message->sujet->forum->id) !!} {{ $temps->message($messages->created_at) }} <br />
            @else
                 <b>message original</b><br />
            @endif
            <br />
            {!! $smiley->parse($bbcode->get(nl2br(e($messages->contenu)))) !!}
            <hr />
            <?php $count++; ?>
        @endforeach
    </div>
</div>
@endsection
