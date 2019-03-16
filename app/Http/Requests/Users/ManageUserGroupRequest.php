<?php

namespace App\Http\Requests\Users;

use Urameshibr\Requests\FormRequest;

class ManageUserGroupRequest extends FormRequest
{
	public function authorize()
	{
		return $this->user()->hasPermission('users.group.change');
	}

	public function rules()
	{
		return [];
	}
}