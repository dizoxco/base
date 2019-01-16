<?php

namespace App\Http\Requests\Wishlist;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWishlistRequest extends FormRequest
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
            'user_id' =>  'bail|numeric|exists:users,id',
            'product_id' =>  [
                'bail',
                'numeric',
                'exists:products,id',
                Rule::unique('wishlists', 'product_id')
                    ->where('user_id', auth_user()->id),
            ],
        ];
    }
}
