<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConnexionRequest extends Request
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
            'pseudo' => 'required',
			      'password' => 'required',
			      'stay' => 'sometimes|accepted'
			      //'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
