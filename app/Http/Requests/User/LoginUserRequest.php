<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'         =>  'required|email',
            'password'      =>  'required|string|min:6',
            'remember_me'   =>  'boolean'
        ];
    }
}
