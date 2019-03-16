<?php

namespace App\Http\Requests\Group;

use Urameshibr\Requests\FormRequest;

class UpdateRequest extends FormRequest
{

	public function authorize()
	{
		return $this->user()->hasPermission('group.edit');
    }
    
    public function rules()
    {
        return [];
    }
}