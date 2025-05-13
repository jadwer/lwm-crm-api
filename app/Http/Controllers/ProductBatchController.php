<?php

namespace App\Http\Controllers;

use App\Models\ProductBatch;
use App\Http\Requests\StoreProductBatchRequest;
use App\Http\Requests\UpdateProductBatchRequest;
use App\Http\Resources\ProductBatchResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductBatch::query();

        // Si se proporciona el parámetro product_id, filtramos por él
        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Cargar relaciones necesarias
        $query->with(['warehouse', 'warehouseLocation']);

        // Obtener todos los resultados
        $batches = $query->get();

        // Retornar colección de recursos
        return ProductBatchResource::collection($batches);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductBatchRequest $request)
    {
        $batch = ProductBatch::create($request->validated());
        return new ProductBatchResource($batch);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductBatch $productBatch)
    {
        $productBatch->load(['warehouse', 'warehouseLocation']);
        return new ProductBatchResource($productBatch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductBatchRequest $request, ProductBatch $productBatch)
    {
    $productBatch->update($request->validated());

    return new ProductBatchResource($productBatch->fresh(['warehouse', 'warehouseLocation']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductBatch $productBatch)
    {
        $productBatch->delete();
        return response()->noContent();
    }
}
