<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductBatchRequest extends FormRequest
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
            'batch_number' => 'required|string|max:100',
            'expiration_date' => 'nullable|date',
            'entry_date' => 'nullable|date',
            'quantity' => 'required|numeric|min:0',
            'warehouse_id' => 'required|exists:warehouses,id',
            'warehouse_location_id' => 'required|exists:warehouse_locations,id',
        ];
    }
}
