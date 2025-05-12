<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderItemStoreRequest extends FormRequest
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
            'sales_order_id' => ['required', 'integer', 'exists:sales_orders,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer'],
            'unit_price' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'subtotal' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
        ];
    }
}
