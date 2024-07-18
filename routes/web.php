<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

Route::post('contact_form', function (Request $request) : Response{
    $res = [
        "status" => "success",
        "data" => [
            "mensaje" => $request->mensaje
        ]
    ];
    error_log($request);
    return response(json_encode($res), 200)->header("Content-type","application/json");
});
