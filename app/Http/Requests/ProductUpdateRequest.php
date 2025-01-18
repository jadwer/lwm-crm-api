<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:400'],
            'sku' => ['nullable', 'string', 'max:50', Rule::unique('products')->ignore(request()->sku, 'sku')],
            'description' => ['required', 'string'],
            'full_description' => ['required', 'string'],
            'price' => ['nullable', 'double'],
            'cost' => ['nullable', 'double'],
            'img_path' => ['nullable', 'string', 'max:400'],
            'datasheet_path' => ['nullable', 'string', 'max:400'],
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
        ];
    }
}
