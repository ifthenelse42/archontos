<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

use App\Moderation;
use App\Message;
use App\Message_historique;

class Edit
{
    private $tempsEdit = 5;

    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            $id = $request->id;

            $date = \Carbon\Carbon::now();
            $newDate = Message::find($id)->created_at->addMinutes($this->tempsEdit);
            $idSujet = Message::find($id)->sujet->id;

            if(Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE OR
            Moderation::where([ // si il est modérateur du forum où le message est, et si son mandat a débuté et n'a pas fini
				['utilisateurs_id', Auth::user()->id],
				['forum_id', Message::find($id)->sujet->forum->id],
				['mandat_debut', '<=', Carbon::now()],
				['mandat_fin', '>=', Carbon::now()],
			])->count() == 1 OR
            Message::find($id)->utilisateurs_id == Auth::user()->id) { // SOIT il est l'auteur du message, SOIT il est administrateur SOIT il est modérateur avec un mandat valide.
                if(Message::where('sujet_id', $idSujet)->orderBy('id', 'ASC')->first()->id == $id OR
                Moderation::where([ // si il est modérateur du forum où le message est, et si son mandat a débuté et n'a pas fini
    				['utilisateurs_id', Auth::user()->id],
    				['forum_id', Message::find($id)->sujet->forum->id],
    				['mandat_debut', '<=', Carbon::now()],
    				['mandat_fin', '>=', Carbon::now()],
    			])->count() == 1 OR
                Auth::user()->level >= 3 && session()->has('admins_unlock') && session()->get('admins_unlock') == TRUE) { // si c'est le premier message du sujet, on laisse passer
                    return $next($request);
                } else { //si c'est pas le premier message du sujet, on vérifie
                    if($date < $newDate) {
                        return $next($request);
                    } else {
                        return back()->with('error', "Vous ne pouvez plus modifier ce message. Le délai est dépassé.");
                    }
                }
            } else {
                return redirect('/')->with('error', "Vous ne pouvez pas modifier ce message car il ne vous appartiens pas.");
            }
        } else {
            return redirect('/')->with('error', "Vous devez être connecté pour modifier un message.");
        }
    }
}
