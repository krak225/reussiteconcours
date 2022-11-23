<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Auth;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		return [
			'nom' => 'required|string|max:255',
			'prenoms' => 'required|string|max:255',
            'email' => 'required|unique:tb_users|max:50',
            'password' => 'required|confirmed|min:8',
		];
    }
}
