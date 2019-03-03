<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
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
        $tag = null;
        if ($this->route()->hasParameter('tag')) {
            $tag = $this->route()->parameter('tag')->id;
        }

        return [
            'label' => 'required|string',
            'metadata' => 'nullable|array',
        ];
    }
}
