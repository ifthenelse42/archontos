<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompteRequest extends Request
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
            'email' => 'filled|email|unique:utilisateurs,email',
			'password' => 'filled|confirmed|min:3',
			'avatar' => 'filled|file|image|mimes:jpg,jpeg,bmp,png,swg,gif|max:2048|dimensions:min_width=80,min_height=80',

            /* PROFIL */
            'presentation' => 'sometimes|between:5,600',
            'activity' => 'sometimes|accepted',

			/* OPTIONS */
			'invisible' => 'sometimes|accepted',
			'anonymous' => 'sometimes|accepted'
        ];
    }
}
