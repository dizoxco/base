<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $validation = config('auth.via.'.service_type($this->input('service')).'.validation');
        return [
            'name'      =>  'required',
            'service'   =>  $validation,
            'password'  =>  'required|string|min:6|max:30|confirmed',
            'avatar'    =>  'sometimes|image',
        ];
    }
}
