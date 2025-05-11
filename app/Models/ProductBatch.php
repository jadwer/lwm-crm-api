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

    /**
     * Un lote pertenece a un producto.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }}
