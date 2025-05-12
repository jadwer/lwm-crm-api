<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'order_date' => $this->order_date,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'notes' => $this->notes,
            'supplier' => SupplierResource::make($this->whenLoaded('supplier')),
            'purchaseOrderItems' => PurchaseOrderItemCollection::make($this->whenLoaded('purchaseOrderItems')),
        ];
    }
}
