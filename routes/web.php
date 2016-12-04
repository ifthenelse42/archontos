<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Protection des variables des urls
Route::pattern('id', '[0-9]+');
Route::pattern('idForum', '[0-9]+');
Route::pattern('idMessage', '[0-9]+');
Route::pattern('page', '[0-9]+');
Route::pattern('titre', '[a-z-0-9-]+');
Route::pattern('pseudo', '[a-z-0-9_-]+');
Route::pattern('destinataire', '[a-z-A-Z-]+');

Route::get('maintenance', function ()
{
    return view('maintenance');
});

Route::get('template', function ()
{
    return view('template');
});

Route::get('exclu', function ()
{
    return view('exclu');
});

Route::get('test', function ()
{
    $array =
    [
    1 => ['usage' => ':-)', 'image' => 'img src'],
    2 => ['usage' => ':)', 'image' => 'img src']
    ]
    ;

    return view('test')->with('array', $array);
});

Route::get('condition-generale-utilisation', function ()
{
    return view('cgu');
});

// Page d'accueil
Route::get('/', 'IndexController@index');

// Connexion
Route::get('connexion', 'ConnexionController@getForm');
Route::post('connexion', 'ConnexionController@postForm');
Route::get('deconnexion', 'ConnexionController@deconnexion');

// Inscription
Route::get('inscription', 'InscriptionController@getForm');
Route::post('inscription', 'InscriptionController@postForm');

// Forum
Route::get('forum', 'ForumController@index');
Route::get('forum/{id}/{titre?}', 'ForumController@show');
// on utilise le controller des sujets car c'est un sujet qui est créé, nuance.
Route::post('forum/{id}/{titre?}', 'SujetController@store');

// Sujet
Route::get('sujet/{id}/{titre?}', 'SujetController@show');
Route::post('sujet/{id}/{titre?}', 'MessageController@store');

Route::post('sujet/{id}/{titre?}', 'MessageController@store');


// Messages
Route::get('message/edit/{id}', 'MessageController@getEdit');
Route::get('message/historique/{id}', 'MessageController@historique');

Route::post('message/edit/{id}', 'MessageController@postEdit');
Route::post('message/apercu', 'MessageController@getApercu');
Route::post('message/apercu/send', 'MessageController@postApercu');
Route::post('message/citation/{id}', 'MessageController@citation');

// Messages privées
Route::get('mp', 'MpController@index');
Route::get('mp/{id}/{titre?}', 'MpController@show');

Route::get('mp/new', 'MpController@getNew');
Route::get('mp/new/{destinataire}', 'MpController@getNewWithDestinataire');
Route::post('mp/new', 'MpController@postNew');

Route::post('mp/{id}', 'MpController@store');

Route::post('mp/{id}/add/participant', 'MpController@addParticipants');
Route::get('mp/{id}/delete/participant/{idMembre}', 'MpController@deleteParticipants');

Route::get('mp/{id}/leave/participant', 'MpController@leaveParticipant');
Route::get('mp/vu/all', 'MpController@vuAll');
Route::get('mp/delete/all', 'MpController@deleteAll');

// Fonctions d'administration des sujets
Route::get('sujet/delete/{id}', 'SujetController@destroy');
Route::get('sujet/epingle/{id}', 'SujetController@epingle');
Route::get('sujet/verrouille/{id}', 'SujetController@verrouille');

Route::get('message/delete/{id}', 'MessageController@destroy');

/* FONCTIONS D'ADMINISTRATION
----------------------------------------------------------- */
// Formulaire de déverrouillage des droits
Route::get('admin/unlock', 'AdminController@getUnlock');
Route::post('admin/unlock', 'AdminController@postUnlock');

// Get de l'administration
Route::get('admin/index', 'AdminController@index');
Route::get('admin/membre', 'AdminController@indexMembre');
Route::get('admin/membre/ban/{id}', 'AdminController@banMembre');
Route::get('admin/membre/promote/admin/{id}', 'AdminController@getPromoteAdmin');
Route::get('admin/membre/promote/moderation/{id}', 'AdminController@getPromoteModeration');
Route::get('admin/membre/empty/{id}', 'AdminController@emptyMembre');
Route::get('admin/exclusion', 'AdminController@indexExclusion');
Route::get('admin/exclusion/{id}/{idForum}/{idMessage}', 'AdminController@getExclusion');
Route::get('admin/exclusion/delete/{id}', 'AdminController@deleteExclusion');
Route::get('admin/categorie/edit/{id}', 'AdminController@getEditCategorie');
Route::get('admin/categorie/delete/{id}', 'AdminController@deleteCategorie');
Route::get('admin/categorie/empty/{id}', 'AdminController@emptyCategorie');
Route::get('admin/forum', 'AdminController@indexForum');
Route::get('admin/forum/edit/{id}', 'AdminController@getEditForum');
Route::get('admin/forum/delete/{id}', 'AdminController@deleteForum');
Route::get('admin/forum/empty/{id}', 'AdminController@emptyForum');
Route::get('admin/maintenance', 'AdminController@indexMaintenance');
Route::get('admin/moderation', 'AdminController@indexModeration');
Route::get('admin/moderation/mandat/delete/{id}', 'AdminController@deleteModerationMandat');
//Route::get('admin/maintenance/lockdown', 'AdminController@lockdown');

// Post de l'administration
Route::post('admin/forum', 'AdminController@addForum');
Route::post('admin/categorie/edit/{id}', 'AdminController@postEditCategorie');
Route::post('admin/categorie', 'AdminController@addCategorie');
Route::post('admin/forum/edit/{id}', 'AdminController@postEditForum');
Route::post('admin/membre/promote/admin/{id}', 'AdminController@postPromoteAdmin');
Route::post('admin/membre/promote/moderation/{id}', 'AdminController@postPromoteModeration');
Route::post('admin/moderation/mandat/add/{id}', 'AdminController@postModerationMandat');
Route::post('admin/moderation/mandat/key/{id}', 'AdminController@postModerationKey');
Route::post('admin/exclusion/{id}/{idForum}/{idMessage}', 'AdminController@postExclusion');
// Dans les forums
Route::get('utilisateurs/bannir/{id}/{idMessage}', 'UtilisateursController@bannir');

Route::get('admin', function ()
{
    return redirect('admin/index');
});
/* FONCTIONS D'ADMINISTRATION FIN
----------------------------------------------------------- */


/* FONCTION DE MODERATION
----------------------------------------------------------- */

// Get de la modération
Route::get('moderation/unlock', 'ModerationController@getUnlock');

// Modération des sujets
Route::get('sujet/mod/delete/{id}', 'ModerationController@sujetDestroy');
Route::get('sujet/mod/epingle/{id}', 'ModerationController@sujetEpingle');
Route::get('sujet/mod/verrouille/{id}', 'ModerationController@sujetVerrouille');
Route::get('message/mod/delete/{id}', 'ModerationController@messageDestroy');
Route::get('moderation/exclusion/{id}/{idForum}/{idMessage}', 'ModerationController@getExclusion');

// Post de la modération
Route::post('moderation/unlock', 'ModerationController@postUnlock');
Route::post('moderation/exclusion/{id}/{idForum}/{idMessage}', 'ModerationController@postExclusion');

/* FONCTION DE MODERATION FIN
----------------------------------------------------------- */

// Compte
Route::get('compte', 'UtilisateursController@index');
Route::post('compte', 'UtilisateursController@postIndex');

// Profil
Route::get('membre/{pseudo}', 'ProfilController@show');

// Si une erreur important est survenue
Route::get('error', function ()
{
    return view('errors.important');
});
