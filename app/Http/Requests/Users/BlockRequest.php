<?php

namespace App\Http\Requests\Users;

use Urameshibr\Requests\FormRequest;

class BlockRequest extends FormRequest
{
	public function authorize()
	{
		return $this->user()->hasPermission('users.block');
	}

	public function rules()
	{
		return [
            'user.status' => 'required|integer',
		];
	}
}