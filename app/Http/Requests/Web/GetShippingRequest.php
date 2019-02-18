<?php

namespace App\Http\Requests\Web;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class GetShippingRequest extends FormRequest
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
        $cart = Auth::user()->cart();
        if (! $cart->count()) {
            $this->merge(['cart' => 0,]);
            return ['cart' => 'required|min:1'];
        }

        $check = $cart->with('variation')->get()->every(function ($item) {
            return $item->quantity <= $item->variation->quantity;
        });
        if (! $check) {
            $this->merge(['check' => $check,]);
            return ['check' => 'accepted'];
        }

        return [];
    }

    public function messages()
    {
        return [
            'cart.min' => 'سبد خرید خالی است.',
            'check.accepted' => 'بیش از موجودی انبار در انتخاب کرده اید.',
        ];
    }
}
