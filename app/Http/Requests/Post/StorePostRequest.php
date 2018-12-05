<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
        $this->request->set('slug', str_slug($this->request->get('slug')));
        return [
            'title'         =>  'required|string',
            'slug'          =>  'required|string|unique:posts,slug',
            'abstract'      =>  'required|string',
            'body'          =>  'required|string',
            'banner'        =>  'file',
            'attachments.*' =>  'file',
        ];
    }
}
