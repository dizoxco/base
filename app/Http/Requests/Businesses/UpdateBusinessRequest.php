<?php

namespace App\Http\Requests\Businesses;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessRequest extends FormRequest
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
        $business = $this->route()->parameter('business');

        return [
            'brand' => ['required', Rule::unique('businesses', 'id')->ignore($business->id)],
            'slug' => ['required',Rule::unique('businesses', 'id')->ignore($business->id)],
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
