<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogCategoryRequest extends FormRequest
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
            'name'      => 'required|string|min:3|max:100|unique:blog_categories,name',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'status'    => 'required|integer',
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
            'name.required' => 'Blog Category Name must be Required',
            'name.unique' => 'Blog Category Name Already Exists',
            'image.required' => 'Blog image required',
            'status.integer' => 'Select a valid status',
        ];
    }

}
