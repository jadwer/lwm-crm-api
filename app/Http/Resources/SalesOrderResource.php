<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'order_date' => $this->order_date,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'notes' => $this->notes,
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'salesOrderItems' => SalesOrderItemCollection::make($this->whenLoaded('salesOrderItems')),
        ];
    }
}
