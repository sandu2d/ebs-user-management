<?php

namespace App\Http\Requests\Permission;

use Urameshibr\Requests\FormRequest;

class GetAllRequest extends FormRequest
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