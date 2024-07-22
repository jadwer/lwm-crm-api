<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

// Route::prefix('v1')->group(function(){

    Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('test', function(){
        return "ok";
    });

    Route::get('CSVImport', [App\Http\Controllers\CsvimportController::class,'index']);
    Route::post('CSVImport', [App\Http\Controllers\CsvimportController::class,'store']);


// });

Route::apiResource('products', App\Http\Controllers\ProductController::class);

Route::apiResource('units', App\Http\Controllers\UnitController::class);

Route::apiResource('categories', App\Http\Controllers\CategoryController::class);

Route::apiResource('brands', App\Http\Controllers\BrandController::class);

Route::post('send_form.php', function (Request $request) : Response{
    $res = [
        "status" => "success",
        "data" => [
            ]
        ];        
    
    return response(json_encode($res), 200)->header("Content-type","application/json");
});
