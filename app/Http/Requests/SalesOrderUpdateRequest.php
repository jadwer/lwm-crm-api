<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderUpdateRequest extends FormRequest
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
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'order_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,confirmed,shipped,delivered,cancelled'],
            'total_amount' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
