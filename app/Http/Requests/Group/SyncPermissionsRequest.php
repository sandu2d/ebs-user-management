<?php

namespace App\Http\Requests\Group;

use Urameshibr\Requests\FormRequest;

class SyncPermissionsRequest extends FormRequest
{

	public function authorize()
	{
        return $this->user()->hasPermission('group.permissions');
    }
    
    public function rules()
    {
        return [
            'group.permissions' => 'required|array',
        ];
    }
}