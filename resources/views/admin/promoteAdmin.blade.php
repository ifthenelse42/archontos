@extends('template.all')

@section('titre') Administration @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-9">
			<h3>Promouvoir un membre</h3><hr />
			<p class="text-muted">Vous êtes sur le point de promouvoir "{{ $identificate->pseudo($id) }}" en tant qu'administrateur. Pour procéder à cela, vous devez lui désigner un mot de passe secret qui lui servira à déverrouiller ses droits à chaque fois qu'il se connectera.<br />
			<br />
			Le mot de passe secret doit être gardé précieusement, car il ne peut pas être modifié ni consulté.</p>
			<form action="{{ url('admin/membre/promote/admin/'.$id) }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="secret_password" class="sr-only"></label>
					<input type="text" name="secret_password" class="form-control" placeholder="Mot de passe secret"></input>
				</div>

				<div class="pull-left">
					<input class="btn btn-primary btn-block" type="submit" value="Enregistrer">
				</div>
			</form>
		</div>
		@include('admin.menu')
	</div>
@endsection
