<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildCategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:100|unique:product_categories,name',
            'product_subcategory_id' => 'required|integer',
            'status' => 'required|integer',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Product child category name must be required',
            'name.unique' => 'Product child category name already exists',
            'status.integer' => 'Select a valid status',
            'product_subcategory_id.integer' => 'Select a valid product sub category name',
            'product_subcategory_id.required' => 'Product sub category name must be required',
        ];
    }

}
