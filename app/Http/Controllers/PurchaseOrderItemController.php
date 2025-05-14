<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderItemStoreRequest;
use App\Http\Requests\PurchaseOrderItemUpdateRequest;
use App\Http\Resources\PurchaseOrderItemCollection;
use App\Http\Resources\PurchaseOrderItemResource;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchaseOrderItemController extends Controller
{
    public function index(Request $request): Response
    {
        $purchaseOrderItems = PurchaseOrderItemResource::collection(PurchaseOrderItem::filters($request)->paginate(12)->setPath(""))->resource;

        return response($purchaseOrderItems, 200);

    }

    public function store(PurchaseOrderItemStoreRequest $request): Response
    {
        $purchaseOrderItem = PurchaseOrderItem::create($request->validated());

        return response(new PurchaseOrderItemResource($purchaseOrderItem), 201);
    }

    public function show(Request $request, PurchaseOrderItem $purchaseOrderItem): Response
    {
        return response(new PurchaseOrderItemResource($purchaseOrderItem), 200);
    }

    public function update(PurchaseOrderItemUpdateRequest $request, PurchaseOrderItem $purchaseOrderItem): Response
    {
        $purchaseOrderItem->update($request->validated());

        return response(new PurchaseOrderItemResource($purchaseOrderItem), 200);
    }

    public function destroy(Request $request, PurchaseOrderItem $purchaseOrderItem): Response
    {
        $purchaseOrderItem->delete();

        return response()->noContent();
    }
}
