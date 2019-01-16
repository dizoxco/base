<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = request()->route()->parameter('user') ?? auth_user();

        return [
            'name'      =>  'required',
            'email'     =>  [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password'  =>  'nullable|string|min:6|max:30|confirmed',
            'avatar'    =>  'image',
        ];
    }
}
