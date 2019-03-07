<?php

namespace App\Http\Requests\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $product = $this->route()->parameter('product');

        return [
            'title' =>  'required|string',
            'slug' => ['required', Rule::unique('products', 'slug')->ignore($product->id)],
            'abstract'      =>  'required|string',
            'body'          =>  'required|string',
            'attributes'    =>  'nullable|array',
            'options'       =>  'nullable|array',
            'single'        =>  'boolean',
            'price'         =>  'numeric',
            'status'        =>  'integer',
            'available_at'  =>  'datetime',
        ];
    }
}
