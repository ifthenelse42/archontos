<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class Profil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(User::where('pseudo', $request->pseudo)->count() > 0) {
            return $next($request);
        } else {
            return redirect('/')->with('error', "Ce membre n'existe pas.");
        }
    }
}
