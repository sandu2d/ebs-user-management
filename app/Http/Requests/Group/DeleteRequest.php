<?php

namespace App\Http\Requests\Group;

use Urameshibr\Requests\FormRequest;

class DeleteRequest extends FormRequest
{

	public function authorize()
	{
		return $this->user()->hasPermission('group.delete');
    }
    
    public function rules()
    {
        return [];
    }
}