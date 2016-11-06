<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

// bite
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
			\App\Http\Middleware\SessionSql::class,
			\App\Http\Middleware\Lockdown::class,
			\App\Http\Middleware\ifExist::class,
			\App\Http\Middleware\ModerationHandle::class,
			\App\Http\Middleware\GodMode::class,
			\App\Http\Middleware\ExclusionHandle::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
		// SECURITE DES SESSIONS ET DES PAGES ASSOCIES \\
		// ----------------------------------------------- \\


        'auth' => \App\Http\Middleware\Authenticate::class,
		// Si l'utilisateur est connecté, alors il n'aura pas accès à la page
		'ifAuth' => \App\Http\Middleware\ifAuth::class,
		// Si l'utilisateur n'est pas connecté, alors il n'aura pas accès à la page
		'ifNotAuth' => \App\Http\Middleware\ifNotAuth::class,
		// Si l'utilisateur est au moins un administrateur ET a déverrouillé ses droits
		'admin' => \App\Http\Middleware\Admin::class,
		// Si l'utilisateur est au moins un administrateur et n'a pas déverrouillé ses droits
		'adminLevel' => \App\Http\Middleware\AdminLevel::class,
		// Si l'utilisateur est au moins un modérateur
		'moderation' => \App\Http\Middleware\ModerationCheck::class,
		// Si l'utilisateur est au moins un modérateur et n'a pas déverrouillé ses droits
		'moderationLevel' => \App\Http\Middleware\ModerationLevel::class,
		// Si l'utilisateur est le webmaster, il aura accès à la page
		'webmaster' => \App\Http\Middleware\Webmaster::class,
		// Si le sujet est verrouillé, on bloque la requête
		'ifLock' => \App\Http\Middleware\ifLock::class,
		// Si l'utilisateur n'est pas un participant du message privé, alors on l'empêche d'accéder au message privé.
		'mpPrivate' => \App\Http\Middleware\mpPrivate::class,
		// Si l'utilisateur n'a pas le droit d'accès à un certain type de forum, alors on l'en empêche.
		'forumType' => \App\Http\Middleware\forumType::class,
		// Si l'utilisateur n'a pas le droit d'accès à un certain type de forum, alors on l'en empêche.
		'forumDelete' => \App\Http\Middleware\forumDelete::class,
		// Protection anti-flood fonctionnant dans les forums et les mps
		'antiFlood' => \App\Http\Middleware\antiFlood::class,
        // Sécurisation de la fonction edit
		'edit' => \App\Http\Middleware\Edit::class,
        // Sécurisation des profils
		'profil' => \App\Http\Middleware\Profil::class,
		// Si le message ou forum de l'exclusion voulue n'existe pas
		'exclusionExist' => \App\Http\Middleware\exclusionExist::class,

		// ----------------------------------------------- \\
		// FIN SECURITE DES SESSIONS ET DES PAGES ASSOCIES \\
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
