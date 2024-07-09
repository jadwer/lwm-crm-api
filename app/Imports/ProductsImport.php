<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $categories;
    private $units;
    private $brands;

    public function __construct()
    {
        $this->categories = Category::pluck('id', 'name');
        $this->units = Unit::pluck('id', 'name');
        $this->brands = Brand::pluck('id', 'name');
    }

    public function model(array $row)
    {
        return new Product([

            // sku,ID. DE PRODUCTO,MARCA,LINEA,CATEGORIA,DESCRIPCION DE PRODUCTO,Descripcion tecnica,UNIDAD DE MEDIDA,IMAGEN DEL PRODUCTO ,DataSheet,precio mxn +IVA,precio DLS +IVA

            'name' => $row['descripcion'],
            'sku' => $row['id'],
            'description' => $row['descripcion'],
            'full_description' => $row['descripcion_tecnica'] ? $row['descripcion_tecnica'] : "",
            'img_path' => $row['imagen'],
            'datasheet_path' => $row['datasheet'],
            // 'unit_id' => $this->units[$row['medida']],
            // 'category_id' => $this->categories[$row['categoria']],
            // 'brand_id' => $this->brands[$row['marca']],
            'unit_id' => 1,
            'category_id' => 1,
            'brand_id' => 1,
        ]);
    }

    public function batchSize(): int 
    {
        return 1000;
    }

    public function chunkSize(): int 
    {
        return 1000;
    }
}
