<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo WarehouseLocation
 *
 * Ubicaciones internas dentro de una bodega.
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property-read Warehouse $warehouse
 */
class WarehouseLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Una ubicación pertenece a una bodega.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Una ubicación puede tener muchos registros de stock.
     */
    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
