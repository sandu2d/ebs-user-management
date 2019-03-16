<?php

namespace App\Http\Requests\Users;

use Urameshibr\Requests\FormRequest;

class DeleteRequest extends FormRequest
{
	public function authorize()
	{
		return $this->user()->hasPermission('users.delete');
	}

	public function rules()
	{
		return [];
	}
}