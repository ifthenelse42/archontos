@extends('template.all')

@section('titre') Accueil @endsection

@section('contenu')
<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default panel-accueil">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Derniers sujets</h3>
				</div>
					<div class="panel-body-list">

						<div class="row">
							<table class="table table-striped table-sujet col-lg-12">
								@foreach($liste->listLastSujet() as $listLastSujet)
									<tr>
										<td class="td-sujet">
											<a href="{{ url('sujet/'.$listLastSujet->id.'/'.str_slug($listLastSujet->titre, '-')) }}">
												<div class="pull-right text-muted">{{ $nbReponses->get($listLastSujet->id) }} message(s)&nbsp;</div>
												{{ $listLastSujet->titre }}
											</a>
										</td>
									</tr>
								@endforeach
							</table>
						</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default panel-accueil">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Derniers messages</h3>
				</div>
					<div class="panel-body-list">

						<div class="row">
							<table class="table table-striped table-sujet col-lg-12">
								@foreach($liste->listLastMsg() as $listLastMsg)
								<tr>
									<td class="td-sujet">
										<a href="{{ $find->url($listLastMsg->id) }}">
											<div class="pull-right text-muted">@if($listLastMsg->anonymous == 1)
												{!! $identificate->pseudoWithlevel($listLastMsg->utilisateurs_id, 1) !!}&nbsp;
											@else
												{!! $identificate->pseudoWithlevel($listLastMsg->utilisateurs_id, 0, $listLastMsg->idForum) !!}&nbsp;
											@endif</div>
											{{ $listLastMsg->titre }}
										</a>
									</td>
								</tr>
								@endforeach
							</table>
						</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default panel-accueil">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Derniers inscris</h3>
				</div>
					<div class="panel-body-list">

						<div class="row">
							<table class="table table-striped table-sujet col-lg-12">
								@foreach($liste->lastMembre() as $derniersMembres)
								<tr>
									<td class="td-sujet">
										<a href="{{ url('membre/'.str_slug($derniersMembres->pseudo, '-')) }}">
											<div class="pull-right text-muted">{{ $temps->sujet($derniersMembres->created_at) }}&nbsp;</div>
											{!! $identificate->pseudoWithLevel($derniersMembres->id) !!}
										</a>
									</td>
								</tr>
								@endforeach
							</table>
						</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default panel-accueil">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Membres les plus actifs ce mois-ci</h3>
				</div>
					<div class="panel-body-list">

						<div class="row">
							<table class="table table-striped table-sujet col-lg-12">
								@foreach($liste->membresActif() as $actif)
									<tr>
										<td class="td-sujet">
											<a href="{{ url('membre/'.str_slug($actif->pseudo, '-')) }}">
												<div class="pull-right text-muted">avec {!! $liste->countReturn($actif->count) !!}&nbsp;</div>
												{!! $identificate->pseudoWithLevel($actif->idMembre) !!}
											</a>
										</td>
									</tr>
								@endforeach

							</table>
						</div>
				</div>
			</div>
		</div>
</div>
@endsection
