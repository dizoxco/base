<?php

namespace App\Http\Requests\Businesses;

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
        return $business = [
            'brand' => 'required|unique:businesses,brand',
            'province' => 'required',
            'city' => 'required',
            'tell' => 'required|digits:8',
            'phone_code' => 'required|digits:3',
            'address' => 'required|string',
            'postal_code' => 'required|string',
            'mobile' => 'required|digits:11',
            'storage_address' => 'required|string',
        ];

        /*        $legal_business = [
                    'company_name' => 'required|string',
                    'company_type' => 'required|integer',
                    'company_registration_number' => 'required',
                    'company_national_id' => 'required|numeric',
                    'company_economical_number' => 'required|digits:12',
                    'company_sign_owners' => 'required|string',
                ];

                $private_business = [
                    'owner_name' => 'required|string',
                    'owner_family' => 'required|string',
                    'owner_birth_date' => 'required',
                    'owner_gender' => 'required|boolean',
                    'owner_national_id' => 'required|digits_between:1,10',
                    'owner_national_code' => 'required|digits_between:8,10',
                ];*/
    }
}
