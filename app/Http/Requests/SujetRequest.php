<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SujetRequest extends Request
{
	 public function authorize()
     {
         return true;
     }

     public function rules()
     {
         return [
             'titre' => 'required|between:1,40',
			 'contenu' => 'required|between:1,50000'
         ];
     }
}
