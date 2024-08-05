<?php

namespace App\Http\Controllers;

use App\Imports\BrandsImport;
use App\Imports\CategoriesImport;
use App\Imports\ProductsImport;
use App\Imports\UnitsImport;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class CsvimportController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        //        return response("Holiwi", 200);
        Excel::import(new ProductsImport, 'import/prueba.csv');
        return redirect()->route('products.index')->with('success', 'Productos importados exitosamente');
    }
    
    public function store(Request $request): JsonResponse
    {
        $csv_list = $request->file('selectedList');
        Excel::import(new ProductsImport, $csv_list);
        return response()->json(["status" => "success", "data" => "no content"], 200);

    }

}
