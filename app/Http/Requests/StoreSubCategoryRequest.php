<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
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
            'product_category_id' => 'required|integer',
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
            'name.required' => 'Product Sub-Category Name must be Required',
            'name.unique' => 'Product Sub-Category Name Already Exists',
            'status.integer' => 'Select a valid status',
            'product_category_id.integer' => 'Select a valid Product Category Name',
            'product_category_id.required' => 'Product Category Name must be Required',
        ];
    }
}
