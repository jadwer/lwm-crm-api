<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Http\Resources\SupplierCollection;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    public function index(Request $request): Response
    {
        $suppliers = Supplier::all();

        return response(new SupplierCollection($suppliers), 200);
    }

    public function store(SupplierStoreRequest $request): Response
    {
        $supplier = Supplier::create($request->validated());

        return response(new SupplierResource($supplier), 201);
    }

    public function show(Request $request, Supplier $supplier): Response
    {
        return response(new SupplierResource($supplier), 200);
    }

    public function update(SupplierUpdateRequest $request, Supplier $supplier): Response
    {
        $supplier->update($request->validated());

        return response(new SupplierResource($supplier), 200);
    }

    public function destroy(Request $request, Supplier $supplier): Response
    {
        $supplier->delete();

        return response()->noContent();
    }
}
