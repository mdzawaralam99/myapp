<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'photo'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'product_category_id' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Please enter product name',
            'name.string' => 'Name should be string',
            'price.reuired' => 'Price needed',
            'price.numeric' => 'Price should be either integer or decimal',
            'photo.required' => 'Please select Photo',
            'photo.image' => 'Selected Photo should be either jpg or jpeg or png',
            'product_category_id.required' => 'Product category Id needed',
            'product_category_id.numeric' => 'Product Category should be Integer only'
        ];
    }
}
