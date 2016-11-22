@extends('template.all')

@section('titre') Accueil des forums @endsection

@section('contenu')

<div class="row">
	@foreach($categorie as $categories)
	@if($forum->where('categorie_id', $categories->id)->count() > 0)
		<div class="col-md-12 col-xs-12">
			<div class="list-group list-categorie">
				<span class="list-group-item background-archontos">
					<div class="pull-right">

					</div>
					<h4 class="list-group-item-heading"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> {{ $categories->nom }}</h4>
				</span>
					@foreach($forum
					->where('categorie_id', $categories->id)
					->orderBy('nom', 'ASC')
					->get()
					 as $forums)
						<a href="forum/{{ $forums->id }}/{{ str_slug($forums->nom, "-") }}" class="list-group-item">
							<div class="pull-right">
								{{ $nb->message($forums->id) }}
							</div>
							<h4 class="list-group-item-heading"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> {{ $forums->nom }}</h4>
							<p class="list-group-item-text">
								{!! nl2br(e($forums->description)) !!}
							</p>
						</a>
					@endforeach
			</div>
		</div>
		@else
			<strong>Il n'y a pas de forum dans cette catégorie.</strong>
		@endif
	@endforeach
</div>

@endsection
