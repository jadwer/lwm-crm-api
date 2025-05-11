<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Warehouse
 *
 * Representa una bodega física de almacenamiento.
 *
 * @property int $id
 * @property string $name
 * @property string|null $location
 * @property string|null $notes
 * @property-read \Illuminate\Database\Eloquent\Collection $stock
 * @property-read \Illuminate\Database\Eloquent\Collection $locations
 */

class Warehouse extends Model
{
    use HasFactory;

     protected $guarded = [];

     /**
     * Una bodega puede tener muchas ubicaciones internas.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(WarehouseLocation::class);
    }

    /**
     * Una bodega puede tener muchos registros de stock.
     */
    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

}
