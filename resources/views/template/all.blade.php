@inject('HasViewed', 'App\Repository\Mp\HasViewed')
@inject('quote', 'App\Repository\Forum\Quotes')
@inject('liste', 'App\Repository\Utilisateurs\Liste')

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php
		$titreAccueil = "Archontos | Forum";
		$description = "Description of the forum";
		$keywords = "archontos, any";
		?>
		<meta charset="utf-8">
		<meta name="description" content="{{ $description }}">
		<meta name="keywords" content="{{ $keywords }}">
		<meta name="author" content="IFThenElse">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		@if(Request::segment(1) == 'forum' OR Request::segment(1) == 'mp' OR Request::segment(1) == 'sujet' OR Request::segment(1) == 'admin')
		<meta name="robots" content="noindex,nofollow">
		@endif
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@if(empty(Request::segment(1))) {{ $titreAccueil }} @else @yield('titre') | archontos @endif</title>
		<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/override.css') }}" rel="stylesheet">
		<link href="{{ asset('css/ekko-lightbox.min.css') }}" rel="stylesheet">
		<link rel="shortcut icon" href="{{ asset('images/archontos.ico') }}">

		<script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/ekko-lightbox.min.js') }}"></script>

		<!-- if...then...else -->
	</head>


	<body>
		<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		</script>
		<div class="container container-nav">
			<nav class="navbar navbar-inverse navbar-static-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('images/archontos.png') }}" width="150" height="20" /></a>
					</div>

					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li class="@if(Request::segment(1) == 'forum' OR Request::segment(1) == 'sujet') active @endif"><a href="{{ url('forum') }}"><span class="menu-font">Forums</span></a></li>
						</ul>

						<ul class="nav navbar-nav navbar-right">
							@if(Auth::check() && Auth::user()->level >= 3 && !session()->has('admins_unlock'))
							<li><a href="{{ url('admin/unlock') }}"><span class="glyphicon glyphicon-lock menu-font" aria-hidden="true"></span></a></li>
							@elseif(Auth::check() && Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE)
							<li><a href="{{ url('admin') }}"><span class="glyphicon glyphicon-list-alt menu-font" aria-hidden="true"></span></a></li>
							@endif

							@if(Auth::check() && Auth::user()->level == 2 && !session()->has('moderation_unlock'))
							<li><a href="{{ url('moderation/unlock') }}">Moderation</a></li>
							@endif

							@if(Auth::check())

								<li class="@if(Request::segment(1) == 'mp') active @endif">
									{{-- variable pour obtenir le nombre de nouveau MP : {{ $HasViewed->countNotKnownAppend() }} --}}
								@if($HasViewed->countNotKnownAppend() == 0)
									<a href="{{ url('mp') }}"><span class="glyphicon glyphicon-envelope menu-font" aria-hidden="true"></span></a>
								@else
									<a class="mp-non-lu" href="{{ url('mp') }}"><span class="glyphicon glyphicon-envelope menu-font" aria-hidden="true"></span></a>
								@endif
								</li>
								<li class="@if(Request::segment(1) == 'compte') active @endif"><a href="{{ url('compte') }}"><span class="glyphicon glyphicon-cog menu-font" aria-hidden="true"></span></a></li>
								<li><a href="{{ url('deconnexion') }}"><span class="glyphicon glyphicon-log-out menu-font" aria-hidden="true"></span></a></li>
							@else
								<li><a href="{{ url('inscription') }}"><span class="glyphicon glyphicon-check menu-font" aria-hidden="true"></span></a></li>
								<li><a href="{{ url('connexion') }}"><span class="glyphicon glyphicon-log-in menu-font" aria-hidden="true"></span></a></li>
							@endif
						</ul>
					</div>
				</div>
			</nav>
		</div>

		<div class="container contenu-online">
			<button class="online" type="button" data-toggle="collapse" data-target="#collapseOnline" aria-expanded="false" aria-controls="collapseOnline">
			  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {!! $liste->online(0, 'index', 0) !!}
			</button>
			<div class="collapse" id="collapseOnline">
				<div class="details">
					{!! $liste->online(0, 'index', 1) !!}
				</div>
			</div>
		</div>

		<div class="container contenu">
			{!! \app\Http\Helperfunctions::breadcrumb() !!}
			@if(count($errors) > 0)
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				@foreach ($errors->all() as $errorsGet)
				<li>{{ $errorsGet }}</li>
				@endforeach
			</div>
			@endif

			@if(session('error'))
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ session('error') }}
			</div>
			@endif

			@if(session('success'))
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{!! session('success') !!}
			</div>
			@endif

			@if(session('warning'))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{!! session('warning') !!}
			</div>
			@endif

			@if(session('info'))
			<div class="alert alert-info alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{!! session('info') !!}
			</div>
			@endif

			@yield('contenu')
		</div>

		<div class="container container-nav">
			<footer class="footer">
				<div class="container text-muted">
					<div class="rows">
						<div class="col-md-4 hidden-xs hidden-sm">
							<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> A propos du site<hr />
							archontos - 0.5<br />
							Remerciements à <a href="{{ url('https://gregjs.com') }}">greg-js</a>, Arigine et Rekey<br />
						</div>

						<div class="col-md-4 hidden-xs hidden-sm">
							<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> L'équipe<hr />
							Fondateurs : IFThenElse et Arigine
						</div>

						<div class="col-md-4">
							{!! $quote->get() !!}
						</div>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>
