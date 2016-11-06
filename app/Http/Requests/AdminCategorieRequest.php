<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminCategorieRequest extends Request
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
            'nom' => 'required|between:2,50',
			'type' => 'required|between:0,3'
        ];
    }
}
