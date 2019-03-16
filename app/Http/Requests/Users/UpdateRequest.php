<?php

namespace App\Http\Requests\Users;

use Urameshibr\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
	public function authorize()
	{
		return $this->user()->hasPermission('users.edit');
	}

	public function rules()
	{
		return [
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email',
            'user.password' => 'required|string|max:255',
		];
	}
}