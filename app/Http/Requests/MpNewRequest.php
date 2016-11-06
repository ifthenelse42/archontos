<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MpNewRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'titre' => 'required|between:1,100',
			'contenu' => 'required|between:1,50000',
			'destinataire' => 'required'
        ];
    }
}
