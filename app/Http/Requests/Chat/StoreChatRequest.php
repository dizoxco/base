<?php

namespace App\Http\Requests\Chat;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreChatRequest extends FormRequest
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
            'user_id'   =>  [
                'required',
                'integer',
                'exists:users,id',
                Rule::notIn([auth_user()->id]),
            ],
            'body'      =>  'required_without:file|string',
            'file'      =>  'required_without:body|file',
        ];
    }
}
