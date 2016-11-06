<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InscriptionRequest extends Request
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
            'pseudo' => 'required|between:2,15|alpha_dash|unique:utilisateurs,pseudo',
			'email' => 'required|email|unique:utilisateurs,email',
			'password' => 'required|confirmed|min:3',
			'reglement' => 'required|accepted',
			'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
