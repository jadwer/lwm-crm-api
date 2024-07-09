<?php

namespace App\Http\Controllers;

use App\Imports\BrandsImport;
use App\Imports\CategoriesImport;
use App\Imports\ProductsImport;
use App\Imports\UnitsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class CsvimportController extends Controller
{
    public function index(Request $request): Response
    {
        return response("Holiwi", 200);
    }

    public function store(Request $request): RedirectResponse
    {

//        Excel::import(new UnitsImport, 'import/prueba.csv');
//        Excel::import(new BrandsImport, 'import/prueba.csv');
//        Excel::import(new CategoriesImport, 'import/prueba.csv');
        Excel::import(new ProductsImport, 'import/prueba.csv');

        return redirect()->route('products.index')->with('success', 'Productos importados exitosamente');
    }

}
