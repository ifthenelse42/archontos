<?php

namespace App\Repository\Message;

// Chargement de la base de donnée
use DB;
use Auth;

use Carbon\Carbon;

use App\Message;

class Edit
{
    private $tempsEdit = 5; // temps en minutes dans laquelle un membre peut modifier son message. Est ignoré si c'est le premier message du sujet OU que c'est un modérateur ou administrateur.

	public function isAble($id) {
        $date = \Carbon\Carbon::now();
        $newDate = Message::find($id)->created_at->addMinutes($this->tempsEdit);
        $idSujet = Message::find($id)->sujet->id;

        if(Message::where('sujet_id', $idSujet)->orderBy('id', 'ASC')->first()->id != $id) { // si c'est pas le premier message, on vérifie la date&
            if($date < $newDate) {
                return true;
            } else {
                return false;
            }
        } else { return true; } //si c'est le premier message du sujet, on ignore tous et on permet l'édition
    }
}
