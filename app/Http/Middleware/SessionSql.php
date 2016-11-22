<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use App\Sessions;

use Carbon\Carbon;

// GESTION DES SESSIONS SQL \\
class SessionSql
{
	// Variables des membres en ligne
	// DOIT ETRE SYNCHRO AVEC App\Repository\Utilisateurs\Liste
	protected $minuteEnLigne = 10;
	protected $numberOut = 20;

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(Auth::check())
		{
			$utilisateurs_id = Auth::user()->id;

			if(Auth::user()->invisible == 1
				OR Auth::user()->anonymous == 1) {
				$invisible = 1;
			} else {
				$invisible = 0;
			}
		}

		else
		{
			$utilisateurs_id = 0;
			$invisible = 0;
		}

		if($request->segment(1))
		{
			$location = $request->segment(1);

			if(is_numeric($request->segment(2)))
			{
				$location_id = $request->segment(2);
			}

			else
			{
				$location_id = 0;
			}
		}

		else
		{
			$location = 'index';
			$location_id = 0;
		}

		$date = \Carbon\Carbon::now();
		$ip = \app\Http\Helperfunctions::getIp();

		// si son ip n'est pas présente
		if(Sessions::where('ip', $ip)->count() == 0) {
		Sessions::insert([
			'utilisateurs_id' => $utilisateurs_id,
			'location' => $location,
			'location_id' => $location_id,
			'invisible' => $invisible,
			'ip' => $ip,
			'created_at' => $date,
			'updated_at' => $date
		]);
		}

		// on met à jour
		else
		{
			if(Sessions::where([
				['utilisateurs_id', '>', 0],
				['utilisateurs_id', $utilisateurs_id],
				['updated_at', '>', Carbon::now()->subMinute($this->minuteEnLigne)],
			])->count() > 1) { // si il y a plus d'une sessions pour un pseudo connecté

				// on supprime ses sessions
				Sessions::where('utilisateurs_id', $utilisateurs_id)
				->orWhere('ip', $ip)
				->delete();

				// Puis on recréé la session
				Sessions::insert([
					'utilisateurs_id' => $utilisateurs_id,
					'location' => $location,
					'location_id' => $location_id,
					'invisible' => $invisible,
					'ip' => $ip,
					'created_at' => $date,
					'updated_at' => $date
				]);

				return redirect('/')->with('warning', "Vous avez été redirigé car vous êtes connecté deux fois dans le même compte.");
			}

			Sessions::where('ip', $ip)
				->update([
					'utilisateurs_id' => $utilisateurs_id,
					'location' => $location,
					'location_id' => $location_id,
					'ip' => $ip,
					'invisible' => $invisible,
					'updated_at' => $date
				]);

		}

		return $next($request);
	}
}
