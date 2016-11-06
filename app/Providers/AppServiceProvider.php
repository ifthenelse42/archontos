<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		// techniquement, le preg match correspond à la fonction bbcode [image]
		Validator::extend('url_image', function($attribute, $value, $parameters, $validator) {
			return preg_match('#^((http://)+(i|image)+\.(imgur|noelshack)+\.(com)+\/([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)(png|jpg|jpeg|gif)+)$#i', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
