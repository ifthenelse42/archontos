@extends('template.all')


@section('titre') Gestion du compte @endsection

@section('contenu')
<div class="row compte">
	<div class="col-lg-2 col-sm-3 col-xs-8 col-sm-offset-0 col-xs-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Votre compte</h3>
			</div>
			<div class="panel-body">
				<div class="text-center">
					<div class="pseudo-titre">{!! $identificate->pseudoWithLevel(Auth::user()->id) !!}
					<br />
					{!! $identificate->level(Auth::user()->id) !!}</div>
					<img src="{{ $identificate->avatar(Auth::user()->id) }}" class="img-rounded img-avatar-large" alt="?" />
					<br />
					{!! $identificate->anciennete(Auth::user()->id) !!}
					<br />
					{!! $identificate->nbMessage(Auth::user()->id) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-10 col-sm-9 col-xs-12">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1"><div class="panel-heading" role="tab" id="heading1">
					<h4 class="panel-title">Modifier le profil</h4>
				</div></a>

				<div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
					<div class="panel-body">
						@include('utilisateurs.compte.profil')
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<a class="collapsed" class="accordion-compte" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2"><div class="panel-heading" role="tab" id="heading2">
					<h4 class="panel-title">Modifier l'avatar</h4>
				</div></a>

				<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
					<div class="panel-body">
						@include('utilisateurs.compte.avatar')
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<a class="collapsed" class="accordion-compte" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3"><div class="panel-heading" role="tab" id="heading3">
					<h4 class="panel-title">Modification de l'adresse email</h4>
				</div></a>

				<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
					<div class="panel-body">
						@include('utilisateurs.compte.email')
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4"><div class="panel-heading" role="tab" id="heading4">
					<h4 class="panel-title">Modification du mot de passe</h4>
				</div></a>

				<div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
					<div class="panel-body">
						@include('utilisateurs.compte.password')
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5"><div class="panel-heading" role="tab" id="heading5">
					<h4 class="panel-title">Options du compte</h4>
				</div></a>

				<div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
					<div class="panel-body">
						@include('utilisateurs.compte.option')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
