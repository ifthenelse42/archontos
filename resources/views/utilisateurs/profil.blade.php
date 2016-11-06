@extends('template.all')


@section('titre') Profil de {{ $pseudo }} @endsection

@section('contenu')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
    			<div class="panel-heading">
                    <h3 class="panel-title">Profil</h3>
    			</div>

    			<div class="panel-body">
                    <div class="col-sm-3 col-lg-2 col-profil">
                        <img src="{!! $identificate->avatar($id, 0) !!}" class="img-rounded img-avatar-profil" alt="Avatar" />
                    </div>

                    <div class="col-sm-9 col-lg-10 col-profil">
                        <div id="pseudo"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {!! $identificate->pseudo($id) !!}</div>
                        <hr />
                        <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> {!! $identificate->online($id) !!}</li>
                        <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> {!! $identificate->level($id) !!}</li>
                        <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> {!! $identificate->anciennete($id) !!} d'ancienneté</li>
                        <hr />
                    </div>

                    <div class="col-lg-12">
                        {{ $identificate->presentation($id) }}
                </div>
            </div>

                <div class="panel-footer">
                    <div class="pull-right">
                       <a class="btn btn-sm btn-warning" href="#">Exclure</a>
                    </div>

                    <a class="btn btn-sm btn-success" href="#">Message privé</a>
                </div>
             </div>
             @if($identificate->activity($id) == 1 OR $id == Auth::user()->id)
                 <br />
                 <div class="panel panel-default">
         			<div class="panel-heading">
                         <h3 class="panel-title">Activité @if($identificate->activity($id) == 0) <i>(masqué au public)</i> @endif</h3>
         			</div>

         			<div class="panel-body">
                        <div class="col-md-6 col-profil">
                            <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Nb messages</li>
                            <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Nb sujets</li>
                        </div>
                        <hr class="visible-xs visible-sm" />
                        <div class="col-md-6 col-profil">
                            <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Est actif ou non</li>
                            <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Forum favoris</li>
                            <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Date de la dernière connexion</li>
                            <li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Date d'inscription</li>
                        </div>
                     </div>
                  </div>
              @endif
        </div>
    </div>
    <br />
@endsection
