<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Request()->user()->can('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'stock' => 'required|integer|min:0',
            'article_code' => 'nullable|string|max:255',
            'category' => 'required|integer|Exists:categories,id',
            'sub_category' => 'nullable|integer|Exists:sub_categories,id',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:1500',
        ];
    }
}
