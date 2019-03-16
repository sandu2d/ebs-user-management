<?php

namespace App\Http\Requests\Users;

use Urameshibr\Requests\FormRequest;

class CreateRequest extends FormRequest
{
	public function authorize()
	{
		return $this->user()->hasPermission('users.create');
	}

	public function rules()
	{
		return [
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|string|max:255',
		];
	}
}