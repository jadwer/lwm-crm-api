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
        $salesOrders = SalesOrder::with('customer')->get();

        return response(new SalesOrderCollection($salesOrders), 200);
    }

    public function store(SalesOrderStoreRequest $request): Response
    {
        $validated = $request->validated();
        $items = $validated['items'] ?? [];

        unset($validated['items']);

        $total = collect($items)->sum(
            fn($item) => ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0)
        );

        $validated['total_amount'] = $total;

        $salesOrder = SalesOrder::create($validated);

        foreach ($items as $item) {
            $salesOrder->salesOrderItems()->create($item);
        }

        return response(new SalesOrderResource($salesOrder), 201);
    }

    public function show(Request $request, SalesOrder $salesOrder): Response
    {
        $salesOrder->load('customer');

        return response(new SalesOrderResource($salesOrder), 200);
    }

    public function update(SalesOrderUpdateRequest $request, SalesOrder $salesOrder): Response
    {
        $validated = $request->validated();
        $items = $validated['items'] ?? [];

        unset($validated['items']);

        $total = collect($items)->sum(
            fn($item) => ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0)
        );

        $validated['total_amount'] = $total;

        $salesOrder->update($validated);

        if (!empty($items)) {
            // Elimina los ítems anteriores y guarda los nuevos
            $salesOrder->salesOrderItems()->delete();

            foreach ($items as $item) {
                $salesOrder->salesOrderItems()->create($item);
            }
        }

        return response(new SalesOrderResource($salesOrder), 200);
    }

    public function destroy(Request $request, SalesOrder $salesOrder): Response
    {
        $salesOrder->salesOrderItems()->delete(); // elimina los hijos primero
        $salesOrder->delete();

        return response()->noContent();
    }
}
