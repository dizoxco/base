<?php

namespace App\Http\Requests\SearchPanels;

use Illuminate\Foundation\Http\FormRequest;

class StoreSearchPanelRequest extends FormRequest
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
            'title'          =>  'required|string',
            'description'    =>  'nullable|string',
            'model'          =>  'required|string',
            // 'filters'        =>  'required|json',
            // 'options'        =>  'required|json',
        ];
    }
}
