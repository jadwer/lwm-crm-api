<?php

require __DIR__ . '/auth.php';

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;

use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseLocationController;
use App\Http\Controllers\ProductBatchController;
use App\Http\Controllers\StockController;

// Route::prefix('v1')->group(function(){

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('test', function () {
    return "ok";
});

Route::get('CSVImport', [App\Http\Controllers\CsvimportController::class, 'index']);
Route::post('CSVImport', [App\Http\Controllers\CsvimportController::class, 'store']);


// });


Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('units', UnitController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('brands', BrandController::class)->only(['index', 'show']);


    Route::apiResource('warehouses', WarehouseController::class)->only(['index', 'show']);
    Route::apiResource('warehouse-locations', WarehouseLocationController::class)->only(['index', 'show']);
    Route::apiResource('product-batches', ProductBatchController::class)->only(['index', 'show']);
    Route::apiResource('stock', StockController::class)->only(['index', 'show']);

    Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('products', ProductController::class)->except(['index'])->only(['store', 'update', 'destroy']);
    Route::apiResource('units', UnitController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('categories', CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('brands', BrandController::class)->only(['store', 'update', 'destroy']);

    Route::apiResource('warehouses', WarehouseController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('warehouse-locations', WarehouseLocationController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('product-batches', ProductBatchController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('stock', StockController::class)->only(['store', 'update', 'destroy']);
});


Route::post('send_form.php', function (Request $request): Response {
    $res = [
        "status" => "success",
        "data" => []
    ];

    return response(json_encode($res), 200)->header("Content-type", "application/json");
});

if (! app()->environment('production')) {
    Route::post('/token-login', function (Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        return response()->json([
            'token' => $user->createToken('postman')->plainTextToken,
            'user' => $user,
        ]);
    });
}


Route::apiResource('suppliers', App\Http\Controllers\SupplierController::class);

Route::apiResource('purchase-orders', App\Http\Controllers\PurchaseOrderController::class);

Route::apiResource('purchase-order-items', App\Http\Controllers\PurchaseOrderItemController::class);
