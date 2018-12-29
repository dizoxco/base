<?php

namespace App\Http\Requests\User;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'      =>  'required',
            'email'     =>  [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(auth_user()->id)
            ],
            'password'  =>  'nullable|string|min:6|max:30|confirmed',
            'avatar'    =>  'image'
        ];
    }
}
