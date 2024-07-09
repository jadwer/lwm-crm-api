<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_id' => 'integer',
        'category_id' => 'integer',
        'brand_id' => 'integer',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeFilters(Builder $query, Request $request)
    {
        return $query
        ->when($request->has('name'), function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->name . '%');
/*        })
        ->when($request->has('brand'), function ($query) use ($request) {
            return $query->where('brand', 'like', '%' . $request->brand . '%');
        })
        ->when($request->has('category'), function ($query) use ($request) {
            return $query->where('category', 'like', '%' . $request->category . '%');
*/        });
}
}
