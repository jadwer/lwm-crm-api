<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'full_description' => $this->full_description,
            'price' => $this->price,
            'cost' => $this->cost,
            'img_path' => $this->img_path,
            'datasheet_path' => $this->datasheet_path,
            'unit_id' => new UnitResource(Unit::find($this->unit_id)),
            //'category_id' => $this->category_id,
            'category_id' => new CategoryResource(Category::find($this->category_id)),
            'brand_id' => new BrandResource(Brand::find($this->brand_id)),
        ];
    }
}
