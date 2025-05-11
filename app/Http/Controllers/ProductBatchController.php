<?php

namespace App\Http\Controllers;

use App\Models\ProductBatch;
use App\Http\Requests\StoreProductBatchRequest;
use App\Http\Requests\UpdateProductBatchRequest;
use App\Http\Resources\ProductBatchResource;
use Illuminate\Http\Response;

class ProductBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductBatchResource::collection(ProductBatch::all());
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
        return new ProductBatchResource($productBatch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductBatchRequest $request, ProductBatch $productBatch)
    {
        $productBatch->update($request->validated());
        return new ProductBatchResource($productBatch);
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
