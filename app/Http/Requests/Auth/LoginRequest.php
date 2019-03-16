<?php

namespace App\Http\Requests\Auth;

use Urameshibr\Requests\FormRequest;

class LoginRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
            'user.email' => 'required|email',
            'user.password' => 'required|string|max:255',
		];
	}
}