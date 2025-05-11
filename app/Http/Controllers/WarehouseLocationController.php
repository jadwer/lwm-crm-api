<?php

namespace App\Http\Controllers;

use App\Models\WarehouseLocation;
use App\Http\Requests\StoreWarehouseLocationRequest;
use App\Http\Requests\UpdateWarehouseLocationRequest;
use App\Http\Resources\WarehouseLocationResource;
use Illuminate\Http\Response;

class WarehouseLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WarehouseLocationResource::collection(WarehouseLocation::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseLocationRequest $request)
    {
        $location = WarehouseLocation::create($request->validated());
        return new WarehouseLocationResource($location);
    }

    /**
     * Display the specified resource.
     */
    public function show(WarehouseLocation $warehouseLocation)
    {
        return new WarehouseLocationResource($warehouseLocation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseLocationRequest $request, WarehouseLocation $warehouseLocation)
    {
        $warehouseLocation->update($request->validated());
        return new WarehouseLocationResource($warehouseLocation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WarehouseLocation $warehouseLocation)
    {
        $warehouseLocation->delete();
        return response()->noContent();
    }
}
