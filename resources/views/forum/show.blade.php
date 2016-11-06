@extends('template.all')

@section('titre') Forum {{ $forum2->find($id)->nom }} @endsection

@section('contenu')
<script src="{{ URL::asset('js/enable.js') }}"></script>
<script src="{{ URL::asset('js/insert.js') }}"></script>
<div class="row">
	<div class="col-md-12 col-xs-12">
		@if($sujet2 > 0)
		<div class="panel panel-default panel-forum">
			{!! $design->pagination($id, $sujet, 'forum') !!}
				<div class="panel-heading panel-forum">
					<h3 class="panel-title wrap-text">
						<div class="pull-right"><span class="glyphicon glyphicon-refresh glyphicon-clear" aria-hidden="true" style="cursor: pointer;" onclick="reload()"></span></div>
						{{ $forum2->find($id)->nom }}
					</h3>
				</div>
				<div class="panel-body">
					<ul class="list-group">
						@foreach($sujet as $sujets)
						<li class="list-group-item list-sujet clearfix">
							<div class="col-lg-10 sujet-titre col-md-10 col-xs-12">
								<div class="pull-right text-muted sujet-reponse">{{ $nbReponses->get($sujets->id) }} réponses</div>
								<span class="{{ $status->get($sujets->status, $sujets->ouvert, $nbReponses->get($sujets->id)) }}" aria-hidden="true"></span> <a href="{{ url('sujet/'.$sujets->id.'/'.str_slug($sujets->titre, "-")) }}">{{ $sujets->titre }}</a>
							</div>

							<div class="col-lg-2 sujet-last col-md-2 hidden-xs hidden-sm">
								@if($lastMsg->get($sujets->id)->anonymous)
									<img src="{!! $identificate->avatar($lastMsg->get($sujets->id)->utilisateurs_id, 1) !!}" alt="" class="img-avatar-preview" /> IFThenElse
								@else
									<img src="{!! $identificate->avatar($lastMsg->get($sujets->id)->utilisateurs_id) !!}" alt="" class="img-avatar-preview" /> IFThenElse
								@endif
							</div>

							<div class="col-lg-10 sujet-auteur text-muted col-md-10 col-xs-12">
								<span class="hidden-xs hidden-sm">
									Par @if($sujets->anonymous == 1)
										{!! $identificate->pseudoWithlevel($sujets->utilisateurs_id, 1) !!}
									@else
										{!! $identificate->pseudoWithlevel($sujets->utilisateurs_id) !!}
									@endif
								</span>

								<span class="visible-xs visible-sm">
									Par @if($sujets->anonymous == 1)
										{!! $identificate->pseudoWithlevel($sujets->utilisateurs_id, 1) !!}
									@else
										{!! $identificate->pseudoWithlevel($sujets->utilisateurs_id) !!}
									@endif<div class="pull-right"><img src="{!! $identificate->avatar($lastMsg->get($sujets->id)->utilisateurs_id) !!}" alt="" class="img-avatar-preview" /> {{ $temps->sujet($lastMsg->get($sujets->id)->created_at) }} <a href="{{  $find->url($lastMsg->lastGet($sujets->id)->id) }}"><span class=" glyphicon glyphicon-circle-arrow-right glyphicon-dark" aria-hidden="true" title="Aller au dernier message"></span></a></div>
								</span>
							</div>

							<div class="col-lg-2 sujet-last2 text-muted col-md-2 hidden-xs hidden-sm">
								{{ $temps->sujet($lastMsg->get($sujets->id)->created_at) }} <a href="{{  $find->url($lastMsg->lastGet($sujets->id)->id) }}"><span class=" glyphicon glyphicon-circle-arrow-right glyphicon-dark" aria-hidden="true" title="Aller au dernier message"></span></a>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
			{!! $design->pagination($id, $sujet, 'forum') !!}
		@else
			<div class="alert alert-warning alert" role="alert">
				Il n'y a, pour l'instant, aucun sujet dans ce forum.
			</div>
		@endif

		{!! $design->form($bbcode, $smiley, $id, 0, 'forum') !!}
	</div>
</div>

<script>
	function reload() {
	    location.reload();
	}
</script>
@endsection
