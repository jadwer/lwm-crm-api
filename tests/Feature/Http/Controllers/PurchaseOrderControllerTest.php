$total_amount = 3 * $product->price; // o subtotal si estás sumando los subtotales

$data = [
    'supplier_id' => $supplier->id,
    'status' => 'pending',
    'order_date' => Carbon::now()->toDateString(),
    'total_amount' => $total_amount, // ← importante para pasar validación
    'items' => [
        [
            'product_id' => $product->id,
            'quantity' => 3,
            'unit_cost' => $product->cost,
            'unit_price' => $product->price,
            'subtotal' => 3 * $product->price,
            'iva' => $product->iva,
            'total' => 3 * $product->cost,
        ],
    ],
];

$response = $this->postJson(route('purchase-orders.store'), $data);

$response->assertCreated();

$this->assertDatabaseHas('purchase_orders', [
    'supplier_id' => $supplier->id,
    'total_amount' => $total_amount,
]);
