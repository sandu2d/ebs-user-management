<?php

namespace App\Http\Requests\Group;

use Urameshibr\Requests\FormRequest;

class GetByIdRequest extends FormRequest
{

	public function authorize()
	{
		return true;
    }
    
    public function rules()
    {
        return [];
    }
}