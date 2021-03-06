<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminExclusionRequest extends Request
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
            'definitive' => 'sometimes|accepted',
			'remain' => 'sometimes|numeric',
			'type' => 'required|between:1,3',
			'type-remain' => 'required|between:1,4'
        ];
    }
}
