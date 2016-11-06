@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			@if($moderation->count() > 0)
				<h3>Gestion des modérateurs</h3><hr />
				<p class="text-muted">
					Cette page vous permet de manipuler l'ensemble des modérateurs du forum. Organisé par dossiers accordion, vous pouvez consulter chaque modérateur du passé, présent et futur et gérer leurs mandats. Les dossiers sont classés par ID-utilisateur.<br />
				</br >
				<strong>Supprimer tous les mandats aura comme effet de supprimer le dossier.</strong>
				</p>
				<hr />
				@foreach($moderation->get() as $moderations)
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $moderations->utilisateurs_id }}" aria-expanded="false" aria-controls="collapse{{ $moderations->utilisateurs_id }}"><div class="panel-heading" role="tab" id="heading{{ $moderations->utilisateurs_id }}">
								<h4 class="panel-title">{{ $identificate->pseudo($moderations->utilisateurs_id) }}</h4>
							</div></a>

							<div id="collapse{{ $moderations->utilisateurs_id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $moderations->utilisateurs_id }}">
								<div class="panel-body">
									<h4><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Mandats actif</h4>
									<hr />
									@if($moderationData->where([
										['utilisateurs_id', $moderations->utilisateurs_id],
										['mandat_debut', '<=', $carbon->now()],
										['mandat_fin', '>=', $carbon->now()],
									])->count() > 0)
										@foreach($moderationData->where([
											['utilisateurs_id', $moderations->utilisateurs_id],
											['mandat_debut', '<=', $carbon->now()],
											['mandat_fin', '>=', $carbon->now()],
										])->get() as $mandatActif)
											<li class="list-append">
												<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> {{ $mandatActif->forum->nom }}
												<a href="{{ url('admin/moderation/mandat/delete/'.$mandatActif->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
											</li>
											<li class="list-append">Début du mandat : {{ $temps->date1($mandatActif->mandat_debut) }}</li>
											<li class="list-append">Fin du mandat : {{ $temps->date1($mandatActif->mandat_fin) }}</li>
											<br />
										@endforeach
									@else
										<strong>Il n'y a aucun mandat actif.</strong>
									@endif
									<h4><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Mandats inactif</h4>
									<hr />
									@if($moderationData->where([
										['utilisateurs_id', $moderations->utilisateurs_id],
										['mandat_debut', '>', $carbon->now()],
										['mandat_fin', '>=', $carbon->now()],
									])->count() > 0)
										@foreach($moderationData->where([
											['utilisateurs_id', $moderations->utilisateurs_id],
											['mandat_debut', '>', $carbon->now()],
											['mandat_fin', '>=', $carbon->now()],
										])->get() as $mandatInactif)
										<li class="list-append">
											<span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> {{ $mandatInactif->forum->nom }}
											<a href="{{ url('admin/moderation/mandat/delete/'.$mandatInactif ->id) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
										</li>
										<li class="list-append">Début du mandat : {{ $temps->date1($mandatInactif->mandat_debut) }}</li>
										<li class="list-append">Fin du mandat : {{ $temps->date1($mandatInactif->mandat_fin) }}</li>
										<br />
										@endforeach
									@else
										<strong>Il n'y a aucun mandat non actif.</strong>
									@endif
									<h4><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Ajout d'un mandat</h4>
									<hr />
									<form action="{{ url('admin/moderation/mandat/add/'.$moderations->utilisateurs_id) }}" method="POST">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="form-group">
											<select class="form-control" name="forum">
												@foreach($forum as $forums)
											  		<option value="{{ $forums->id }}">{{ $forums->nom }}</option>
											  	@endforeach
											</select>
										</div>

										<label for="forum">Dates du mandat</label>
										<p class="text-muted">
											Les dates doivent être au format suivant : AAAA-MM-JJ<br />
											Les mandats prennent effet à partir de minuit ; si la date de début est aujourd'hui, il prendra effet immédiatement.<br />
											Lorsque "durée indéfinie" est coché, la case "Fin du mandat" n'est plus comptée.
										</p>
										<div class="form-group">
											<input type="text" name="mandat_debut" class="form-control" placeholder="Début du mandat"></input>
						            	</div>

										<div class="form-group">
											<input type="text" name="mandat_fin" class="form-control" placeholder="Fin du mandat"></input>
						            	</div>

										<div class="checkbox">
										  <label>
										    <input type="checkbox" value="1" name="mandat_indefinie">
										    	Durée indéfinie
										  </label>
										</div>

										<div class="pull-left">
											<input class="btn btn-primary btn-block" type="submit" value="Valider">
										</div>
									</form>
									<br /><br />
									<h4><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Création d'une nouvelle clé de déverrouillage</h4>
									<hr />
									<form action="{{ url('admin/moderation/mandat/key/'.$moderations->utilisateurs_id) }}" method="POST">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="form-group">
											<input type="password" name="secret_password" class="form-control" placeholder="Clé de déverrouillage"></input>
										</div>
										<div class="pull-left">
											<input class="btn btn-primary btn-block" type="submit" value="Valider">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			@else
				<strong>Il n'y a aucun modérateur.</strong>
			@endif
		</div>
		@include('admin.menu')
	</div>
@endsection
