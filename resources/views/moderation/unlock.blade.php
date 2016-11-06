@extends('template.all')

@section('titre') Modération @endsection

@section('contenu')
	<div class="row">
		<div class="col-md-offset-4 col-md-4 col-xs-10 col-xs-offset-1">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Déverrouillage des droits</h3>
			  </div>

			  <div class="panel-body">
				  	<p class="text-muted">Vous devez vous munir de votre clé de déverrouillage afin d'accéder à vos pouvoirs de modérateur.</p>
					<form action="{{ url('moderation/unlock') }}" method="POST" class="form-signin">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label for="password" class="sr-only">Votre mot de passe</label>
							<input type="password" name="password" class="form-control" placeholder="Votre mot de passe"></input>
						</div>

						<div class="form-group">
							<label for="password" class="sr-only">Clé de déverrouillage</label>
							<input type="password" name="secret_password" class="form-control" placeholder="Clé de déverrouillage"></input>
						</div>


				  <div class="form-group">
  					{!! app('captcha')->display(); !!}
  			  	  </div>

				<div class="form-group text-center">
					<input class="btn btn-danger" type="submit" value="Déverrouiller">
				</div>
			</form>
			 </div>
		</div>
	</div>
</div>
@endsection
