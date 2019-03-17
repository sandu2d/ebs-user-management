<?php

namespace App\Http\Requests\Users;

use Urameshibr\Requests\FormRequest;

class ActivateRequest extends FormRequest
{
	public function authorize()
	{
		return $this->user()->hasPermission('users.activate');
	}

	public function rules()
	{
		return [
            'user.status' => 'required|integer',
		];
	}
}