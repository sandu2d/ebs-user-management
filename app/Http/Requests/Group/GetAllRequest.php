<?php

namespace App\Http\Requests\Group;

use Urameshibr\Requests\FormRequest;
use Illuminate\Http\Request;

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