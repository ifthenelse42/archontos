@extends('template.all')

@section('titre') Erreur @endsection

@section('contenu')

<div class="alert alert-danger" role="alert">{{ session('error') ? session('error') : "Il n'y a aucune erreur." }}</div>


@endsection
