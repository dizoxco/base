<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'title' =>  'required|string',
            'slug' => 'required|unique:products,slug',
            'abstract' => 'required|string',
            'body' => 'required|string',
            'attributes' => 'json',
            'variations' => 'json',
            'available_at' => 'date',
            'single' => 'boolean',
        ];
    }
}
