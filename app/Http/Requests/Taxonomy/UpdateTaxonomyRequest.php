<?php

namespace App\Http\Requests\Taxonomy;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxonomyRequest extends FormRequest
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
        $taxonomy_id = $this->route()->parameter('taxonomy')->id;

        return [
            'group_name' => 'required|string',
            'slug' => ['nullable', 'string', Rule::unique('taxonomies', 'slug')->ignore($taxonomy_id)],
            'label' => 'required|string',
        ];
    }
}
