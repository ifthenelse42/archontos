<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MessageRequest extends Request
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
    public function rules() // doit être identique à SujetRequest sur la partie contenu ET les editions
    {
		return [
			'contenu' => 'required|between:1,50000'
		];
    }
}
