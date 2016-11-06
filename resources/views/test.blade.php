@extends('template.all')

@section('titre') Accueil @endsection

@section('contenu')

<div class="row">
	<div class="col-lg-12">
		<ul class="list-group">
			<li class="list-group-item list-sujet clearfix">
				<div class="col-lg-10 sujet-titre col-md-10 col-xs-12">
					<div class="pull-right text-muted">1650 réponses</div>
					<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> <a href="#">Test sujet à la conefezferfsfez frze fzerfze</a>
				</div>

				<div class="col-lg-2 sujet-last col-md-2 hidden-xs hidden-sm">
					<img src="avatars/1.png" class="img-avatar-preview" alt="" /> IFThenElse
				</div>

				<div class="col-lg-10 sujet-auteur text-muted col-md-10 col-xs-12">
					<span class="hidden-xs hidden-sm">
						Par IFThenElse
					</span>

					<span class="visible-xs visible-sm">
						Par IFThenElse<div class="pull-right"><img src="avatars/1.png" class="img-avatar-preview" alt="" /> il y a deux heures <a href="#"><span class=" glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span></a></div>
					</span>
				</div>

				<div class="col-lg-2 sujet-last2 text-muted col-md-2 hidden-xs hidden-sm">
					il y a deux heures <a href="#"><span class=" glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span></a>
				</div>
			</li>
		</ul>
	</div>
</div>

@endsection
