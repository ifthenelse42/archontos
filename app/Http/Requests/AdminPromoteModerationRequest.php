<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminPromoteModerationRequest extends Request
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
            'secret_password' => 'required',
			'forum' => 'required|numeric',
			'mandat_debut' => 'required|date_format:Y-m-d',
			'mandat_fin' => 'sometimes|date_format:Y-m-d',
			'mandat_indefinie' => 'sometimes|accepted'
        ];
    }
}
