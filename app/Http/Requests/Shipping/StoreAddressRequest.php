<?php

namespace App\Http\Requests\Shipping;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest
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
            'address' => [
                'required',
                'numeric',
                Rule::exists('addresses','id')->where(function ($query) {
                    $user_addresses_id = Auth::user()->addresses()->select('id')->pluck('id')->toArray();
                    return $query->whereIn('id', $user_addresses_id);
                })
            ],
        ];
    }
}
