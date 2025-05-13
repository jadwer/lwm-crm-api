<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo ProductBatch
 *
 * Representa un lote de producto con cantidad y caducidad.
 *
 * @property int $id
 * @property string $batch_number
 * @property string|null $expiration_date
 * @property float $quantity
 * @property-read Product $product
 */
class ProductBatch extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
    'product_id',
    'batch_number',
    'quantity',
    'entry_date',
    'expiration_date',
    'warehouse_id',
    'warehouse_location_id'
];

    /**
     * Un lote pertenece a un producto.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouseLocation()
    {
        return $this->belongsTo(WarehouseLocation::class);
    }
}
