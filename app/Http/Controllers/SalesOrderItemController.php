<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderItemStoreRequest;
use App\Http\Requests\SalesOrderItemUpdateRequest;
use App\Http\Resources\SalesOrderItemCollection;
use App\Http\Resources\SalesOrderItemResource;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesOrderItemController extends Controller
{
    public function index(Request $request): Response
    {
        $salesOrderItems = SalesOrderItem::all();

        return response(new SalesOrderItemCollection($salesOrderItems), 200);
    }

    public function store(SalesOrderItemStoreRequest $request): Response
    {
        $salesOrderItem = SalesOrderItem::create($request->validated());

        return response(new SalesOrderItemResource($salesOrderItem), 201);
    }

    public function show(Request $request, SalesOrderItem $salesOrderItem): Response
    {
        return response(new SalesOrderItemResource($salesOrderItem), 200);
    }

    public function update(SalesOrderItemUpdateRequest $request, SalesOrderItem $salesOrderItem): Response
    {
        $salesOrderItem->update($request->validated());

        return response(new SalesOrderItemResource($salesOrderItem), 200);
    }

    public function destroy(Request $request, SalesOrderItem $salesOrderItem): Response
    {
        $salesOrderItem->delete();

        return response()->noContent();
    }
}
