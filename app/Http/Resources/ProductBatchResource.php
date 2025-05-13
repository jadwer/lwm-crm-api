<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductBatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'product_id' => new ProductResource(Product::find($this->product_id)),
            'batch_number' => $this->name,
            'batch_number' => $this->batch_number,
            'quantity' => $this->quantity,
            'entry_date' => $this->entry_date,
            'expiration_date' => $this->expiration_date,
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
            'warehouse_location' => new WarehouseLocationResource($this->whenLoaded('warehouseLocation')),
        ];

    }
}
