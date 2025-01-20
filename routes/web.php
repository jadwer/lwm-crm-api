<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


Route::post('contact_form', function (Request $request) : Response{
    error_log("El mensaje: ".$request->mensaje);
    
    $para = "ventas@laborwasserdemexico.com,jadwer@msn.com";
    $titulo = "Contacto desde el sitio web";
    $mensaje = $request->mensaje;
    $mensaje = wordwrap($mensaje, 70, "\r\n");
    $cabeceras = 'From: ventas@laborwasserdemexico.com' . "\r\n" .
    'Reply-To: ventas@laborwasserdemexico.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    $mensaje = "Haz recibido un mensaje desde el formulario de contacto \r\n
    Nombre: ".$request->nombre."\r\n
    Correo electronico: ".$request->mail."\r\n
    Telefono: ".$request->tel."\r\n
    Mensaje: ".$request->mensaje."\r\n";
    
    try {
        if(mail($para, $titulo, $mensaje, $cabeceras)){
            $res = [
                "status" => "success",
                "data" => [
                    "mensaje" => $request->mensaje
                    ]
                ];        
            } else {
                $res = [
                    "error" => error_get_last(),
                    "data" => [
                        "mensaje" => $request->mensaje
                        ]
                    ];        
                }
            } catch (\Throwable $th) {
                $res = [
                    "error" => $th,
                    "data" => [
                        "mensaje" => $request->mensaje
                        ]
                    ];        
                }
                
                return response(json_encode($res), 200)->header("Content-type","application/json");
            });


Route::post('quotation_form', function (Request $request): Response {
        error_log("El mensaje: ".$request->mensaje);
        
//        $para = "ventas@laborwasserdemexico.com,jadwer@msn.com";
        $para = "ventas@laborwasserdemexico.com,jadwer@msn.com";
        $titulo = "Contacto desde el sitio web";
        $mensaje = $request->mensaje;
        $mensaje = wordwrap($mensaje, 70, "\r\n");
        $cabeceras = 'From: ventas@laborwasserdemexico.com' . "\r\n" .
        'Reply-To: ventas@laborwasserdemexico.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        $mensaje = "Haz recibido un mensaje desde el formulario de contacto \r\n
        Nombre: ".$request->nombre."\r\n
        Correo electronico: ".$request->mail."\r\n
        Telefono: ".$request->tel."\r\n
        Producto: ".$request->producto."\r\n
        Cantidad: ".$request->cantidad."\r\n
        Mensaje: ".$request->mensaje."\r\n";
        
        try {
            if(mail($para, $titulo, $mensaje, $cabeceras)){
                $res = [
                    "status" => "success",
                    "data" => [
                        "mensaje" => $request->mensaje
                        ]
                    ];        
                } else {
                    $res = [
                        "error" => error_get_last(),
                        "data" => [
                            "mensaje" => $request->mensaje
                            ]
                        ];        
                    }
                } catch (\Throwable $th) {
                    $res = [
                        "error" => $th,
                        "data" => [
                            "mensaje" => $request->mensaje
                            ]
                        ];        
                    }
                    
                    return response(json_encode($res), 200)->header("Content-type","application/json");
                });


require __DIR__ . '/auth.php';
