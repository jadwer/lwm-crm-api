<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderStoreRequest;
use App\Http\Requests\SalesOrderUpdateRequest;
use App\Http\Resources\SalesOrderCollection;
use App\Http\Resources\SalesOrderResource;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesOrderController extends Controller
{
    public function index(Request $request): Response
    {
        $salesOrders = SalesOrder::all();

        return response(new SalesOrderCollection($salesOrders), 200);
    }

    public function store(SalesOrderStoreRequest $request): Response
    {
        $salesOrder = SalesOrder::create($request->validated());

        return response(new SalesOrderResource($salesOrder), 201);
    }

    public function show(Request $request, SalesOrder $salesOrder): Response
    {
        return response(new SalesOrderResource($salesOrder), 200);
    }

    public function update(SalesOrderUpdateRequest $request, SalesOrder $salesOrder): Response
    {
        $salesOrder->update($request->validated());

        return response(new SalesOrderResource($salesOrder), 200);
    }

    public function destroy(Request $request, SalesOrder $salesOrder): Response
    {
        $salesOrder->delete();

        return response()->noContent();
    }
}
