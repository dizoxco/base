<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PostLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service'       =>  'required',
            'password'      =>  'required|string|min:6',
            'remember_me'   =>  'boolean',
        ];
    }
}
