@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Gestion des exclusions du forum</h3><hr />
			<p class="text-muted">Cette page sert de gestion des exclusions du forum. Vous pouvez rendre inactif un bannissement ou simplement les consulter. Les exclusions sont rangées par dossiers d'utilisateurs.</p>
			<hr />
			@if($exclusion->count() > 0)
				@foreach($exclusion->get() as $exclusions)
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $exclusions->utilisateurs_id }}" aria-expanded="false" aria-controls="collapse{{ $exclusions->utilisateurs_id }}"><div class="panel-heading" role="tab" id="heading{{ $exclusions->utilisateurs_id }}">
							<h4 class="panel-title">{{ $identificate->pseudo($exclusions->utilisateurs_id) }}</h4>
						</div></a>

						<div id="collapse{{ $exclusions->utilisateurs_id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $exclusions->utilisateurs_id }}">
							<div class="panel-body">
								<h4><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Exclusions actif</h4>
								<hr />
								@if($exclusionData->where([
									['utilisateurs_id', $exclusions->utilisateurs_id],
									['remain', '>', $carbon->now()],
								])->count() > 0)
									@foreach($exclusionData->where([
										['utilisateurs_id', $exclusions->utilisateurs_id],
										['remain', '>', $carbon->now()],
									])->get() as $exclusionDatas)
										<li class="list-append">
											@if($exclusionDatas->type == 1)
												<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> Exclusion du forum "{{ $exclusionDatas->forum->nom }}" <a href="{{ url('admin/exclusion/delete/'.$exclusionDatas->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><br />
												@if($exclusionDatas->definitive == 1)
													<strong>Définitif</strong>.
												@else
													Jusqu'au <strong>{{ $temps->date3($exclusionDatas->remain) }}</strong>.
												@endif
												@if($exclusionDatas->message_id > 0)
													<br /><br />
													<button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}" aria-expanded="false" aria-controls="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
													  Afficher le message ayant conduit au bannissement
													</button>
													<div class="collapse" id="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
														<br />
														Date du message : {{ $temps->date3($exclusionDatas->message->created_at) }}<br />
														> {{ $exclusionDatas->message->contenu }}
													</div>
												@endif
											@elseif($exclusionDatas->type == 2)
												<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> Exclusion globale <a href="{{ url('admin/exclusion/delete/'.$exclusionDatas->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><br />
												@if($exclusionDatas->definitive == 1)
													<strong>Définitif</strong>.
												@else
													Jusqu'au <strong>{{ $temps->date3($exclusionDatas->remain) }}</strong>.
												@endif
												@if($exclusionDatas->message_id > 0)
													<br /><br />
													<button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}" aria-expanded="false" aria-controls="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
													  Afficher le message ayant conduit au bannissement
													</button>
													<div class="collapse" id="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
														<br />
														Date du message : {{ $temps->date3($exclusionDatas->message->created_at) }}<br />
														> {{ $exclusionDatas->message->contenu }}
													</div>
												@endif
											@elseif($exclusionDatas->type == 3)
												<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> Verrouillage du compte <a href="{{ url('admin/exclusion/delete/'.$exclusionDatas->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><br />
												@if($exclusionDatas->definitive == 1)
													<strong>Définitif</strong>.
												@else
													Jusqu'au <strong>{{ $temps->date3($exclusionDatas->remain) }}</strong>.
												@endif
												@if($exclusionDatas->message_id > 0)
													<br /><br />
													<button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}" aria-expanded="false" aria-controls="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
													  Afficher le message ayant conduit au bannissement
													</button>
													<div class="collapse" id="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
														<br />
														Date du message : {{ $temps->date3($exclusionDatas->message->created_at) }}<br />
														> {{ $exclusionDatas->message->contenu }}
													</div>
												@endif
											@endif
										</li>
										<br />
									@endforeach
								@else
									<strong>Il n'y a aucune exclusion active.</strong>
								@endif
								<h4><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Exclusions passées</h4>
								<hr />
								@foreach($exclusionData->where([
									['utilisateurs_id', $exclusions->utilisateurs_id],
									['remain', '<=', $carbon->now()],
								])->get() as $exclusionDatas)
									<li class="list-append">
										@if($exclusionDatas->type == 1)
											<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> Exclusion du forum "{{ $exclusionDatas->forum->nom }}"
											@if($exclusionDatas->message_id > 0)
												<br />
												<button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}" aria-expanded="false" aria-controls="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
												  Afficher le message ayant conduit au bannissement
												</button>
												<div class="collapse" id="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
													<br />
													Date du message : {{ $temps->date3($exclusionDatas->message->created_at) }}<br />
													> {{ $exclusionDatas->message->contenu }}
												</div>
											@endif
										@elseif($exclusionDatas->type == 2)
											<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> Exclusion globale
												@if($exclusionDatas->message_id > 0)
													<br />
													<button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}" aria-expanded="false" aria-controls="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
													  Afficher le message ayant conduit au bannissement
													</button>
													<div class="collapse" id="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
														<br />
														Date du message : {{ $temps->date3($exclusionDatas->message->created_at) }}<br />
														> {{ $exclusionDatas->message->contenu }}
													</div>
												@endif
										@elseif($exclusionDatas->type == 3)
											<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> Verrouillage du compte
												@if($exclusionDatas->message_id > 0)
													<br />
													<button class="btn btn-xs btn-warning" type="button" data-toggle="collapse" data-target="#collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}" aria-expanded="false" aria-controls="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
													  Afficher le message ayant conduit au bannissement
													</button>
													<div class="collapse" id="collapseMessage{{ $exclusionDatas->message->id }}-{{ $exclusionDatas->id }}">
														<br />
														Date du message : {{ $temps->date3($exclusionDatas->message->created_at) }}<br />
														> {{ $exclusionDatas->message->contenu }}
													</div>
												@endif
										@endif
									</li>
									<br />
								@endforeach
							</div>
						</div>
					</div>
				</div>
				@endforeach
			@else
				<strong>Actuellement, personne n'est exclu d'un forum.</strong>
			@endif
		</div>
		@include('admin.menu')
	</div>
@endsection
