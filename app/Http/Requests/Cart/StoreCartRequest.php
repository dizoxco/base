<?php

namespace App\Http\Requests\Cart;

use App\Models\Variation;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
        $v = Variation::find($this->request->getInt('variation_id'));
        $quantity = $v !== null ? $v->quantity : 1;

        return [
            'variation_id' => 'required|numeric|exists:variations,id',
            'quantity' => "required|integer|between:1,$quantity",
        ];
    }
}
