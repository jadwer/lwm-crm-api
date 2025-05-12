<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderStoreRequest;
use App\Http\Requests\PurchaseOrderUpdateRequest;
use App\Http\Resources\PurchaseOrderCollection;
use App\Http\Resources\PurchaseOrderResource;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchaseOrderController extends Controller
{
    public function index(Request $request): Response
    {
        $purchaseOrders = PurchaseOrder::all();

        return response(new PurchaseOrderCollection($purchaseOrders), 200);
    }

    public function store(PurchaseOrderStoreRequest $request): Response
    {
        $purchaseOrder = PurchaseOrder::create($request->validated());

        return response(new PurchaseOrderResource($purchaseOrder), 201); // 👈 importante
    }

    public function show(Request $request, PurchaseOrder $purchaseOrder): Response
    {
        return response(new PurchaseOrderResource($purchaseOrder), 200);
    }

    public function update(PurchaseOrderUpdateRequest $request, PurchaseOrder $purchaseOrder): Response
    {
        $purchaseOrder->update($request->validated());

        return response(new PurchaseOrderResource($purchaseOrder), 200);
    }

    public function destroy(Request $request, PurchaseOrder $purchaseOrder): Response
    {
        $purchaseOrder->delete();

        return response()->noContent(); // equivalente a código 204
    }
}
