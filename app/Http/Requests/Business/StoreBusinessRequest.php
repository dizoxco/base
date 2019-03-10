<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
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
        $this->merge([
            'contact' => json_encode([])
        ]);

        return [
            'brand' => 'required|string',
            'slug' => 'nullable|string',
//            'city_id' => 'required|exists:cities,id',
//            'contact' => 'array',
//            'status' => 'integer',
        ];
    }
}
