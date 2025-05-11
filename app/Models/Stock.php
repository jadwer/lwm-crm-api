<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Stock
 *
 * Representa la existencia de un producto en una bodega.
 *
 * @property int $id
 * @property float $quantity
 * @property float|null $average_cost
 * @property float|null $stock_min
 * @property float|null $stock_max
 * @property float|null $reorder_point
 * @property-read Product $product
 * @property-read Warehouse $warehouse
 * @property-read WarehouseLocation|null $location
 */
class Stock extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * El stock pertenece a un producto.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * El stock pertenece a una bodega.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * El stock puede pertenecer a una ubicación interna.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(WarehouseLocation::class, 'warehouse_location_id');
    }
}
