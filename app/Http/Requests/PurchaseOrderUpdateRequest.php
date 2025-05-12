<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderUpdateRequest extends FormRequest
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
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'order_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,approved,received,cancelled'],
            'total_amount' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
