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
/*
    public function scopeFilters(Builder $query, Request $request)
    {
        $query
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where(function ($query) use ($request){
                    $search = str_word_count($request->name,1, 'áéíóúÁÉÍÓÚÑñ1234567890.');
                    $part = "";
                    foreach ($search as $nombre) {
                        error_log("SearchString: ".$nombre);
                        $query->orWhere('name', 'like', '%' . $nombre . '%')
                        ->orWhere('sku', 'like', '%'.$request->name.'%');
                    }
                });
                    return $query;
            })
            ->when($request->has('brand'), function ($query) use ($request) {
                $query->where(function ($query) use ($request){
                    foreach ($request->brand as $key => $marca) {
                        error_log("marca: ".$marca);
                        $query->orWhere('brand_id', '=', $marca);
                    }
                });
                return $query;
            })
            ->when($request->has('category'), function ($query) use ($request) {
                error_log("categoría: ".$request->category);
                return $query->where('category_id', '=', $request->category);
            })
            ->when($request->has('sort'), function ($query) use ($request) {
                error_log("sorted: ".$request->sort);
                return $query->orderBy($request->sort, 'desc');
            });
         return $query;
    }
*/

public function scopeFilters($query, Request $request)
{
    if ($request->filled('name')) {
        $name = $request->input('name');
        $name = preg_replace('/[[:^print:]]/', '', $name);
        $terms = preg_split('/\\s+/', $name);
        foreach ($terms as $term) {
            $query->where('name', 'like', '%' . $term . '%');
        }
    }

    if ($request->filled('sku')) {
        $sku = $request->input('sku');
        $sku = preg_replace('/[[:^print:]]/', '', $sku);
        $terms = preg_split('/\\s+/', $sku);
        foreach ($terms as $term) {
            $query->where('sku', 'like', '%' . $term . '%');
        }
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->input('category_id'));
    }

    if ($request->filled('brand_id')) {
        $brands = explode(',', $request->input('brand_id'));
        $query->whereIn('brand_id', $brands);
    }

    if ($request->filled('orderBy')) {
        $query->orderBy($request->input('orderBy'), $request->input('direction', 'asc'));
    }
}

}
