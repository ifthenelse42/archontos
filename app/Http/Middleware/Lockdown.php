<?php

namespace App\Http\Middleware;

use Closure;

class Lockdown
{
	// Variable protégé de l'activation de la maintenance
	protected $maintenance = FALSE;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if($this->maintenance == TRUE)
		{
			if(\app\Http\Helperfunctions::getIp() == '159.148.186.135'
			OR \app\Http\Helperfunctions::getIp() == '::1'
			OR \app\Http\Helperfunctions::getIp() == '88.173.142.62'
			OR \app\Http\Helperfunctions::getIp() == '78.228.188.141'
			OR \app\Http\Helperfunctions::getIp() == '87.91.7.115'
			OR \app\Http\Helperfunctions::getIp() == '78.228.188.141'
			OR \app\Http\Helperfunctions::getIp() == '77.203.79.1'
			OR \app\Http\Helperfunctions::getIp() == '80.12.33.85'
			OR $request->segment(1) == 'maintenance')
			{
				return $next($request);
			}

			return redirect('maintenance');
		}

		else
		{
			return $next($request);
		}
    }
}
