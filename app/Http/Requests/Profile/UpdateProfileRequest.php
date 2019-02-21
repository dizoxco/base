<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $rule = [
            'name' => 'required',
            'email' => [
                'required_without:mobile', 'nullable', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore(auth()->user()->id),
            ],
            'mobile' => [
                'required_without:email', 'nullable', 'string', 'iran_mobile',
                Rule::unique('users', 'mobile')->ignore(auth()->user()->id),
            ],
        ];

        if ($this->filled('old_password')) {
            return array_merge($rule, [
                'password' => 'required|string|min:6|confirmed',
            ]);
        }

        return $rule;
    }
}
