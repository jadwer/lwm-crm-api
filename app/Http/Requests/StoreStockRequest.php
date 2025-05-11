<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'warehouse_location_id' => 'nullable|exists:warehouse_locations,id',
            'quantity' => 'required|numeric|min:0',
            'average_cost' => 'nullable|numeric|min:0',
            'stock_min' => 'nullable|numeric|min:0',
            'stock_max' => 'nullable|numeric|min:0',
            'reorder_point' => 'nullable|numeric|min:0',
        ];
    }
}
