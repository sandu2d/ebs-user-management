<?php

namespace App\Http\Requests\Group;

use Urameshibr\Requests\FormRequest;

class CreateRequest extends FormRequest
{

	public function authorize()
	{
		return $this->user()->hasPermission('group.create');
    }
    
    public function rules()
    {
        return [
            'group.name' => 'required|string|max:255',
        ];
    }
}