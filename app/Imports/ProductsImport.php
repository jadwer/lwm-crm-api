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
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
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
        ini_set('max_execution_time', '300');
    }

    public function model(array $row)
    {
        return new Product([


            'name' => $row['descripcion'],
            'sku' => $row['id'],
            'description' => $row['descripcion'],
            'full_description' => $row['descripcion_tecnica'] ? $row['descripcion_tecnica'] : "",
            'price' => $row['precio'] ? $row['precio'] : "",
            'cost' => $row['costo'] ? $row['costo'] : "",
            'iva' => $row['iva'] ? $row['iva'] : "",
            'img_path' => $row['imagen'],
            'datasheet_path' => $row['datasheet'],
            'unit_id' => $row['medida'],
            'category_id' => $row['categoria'],
            'brand_id' => $row['marca'],
            //'unit_id' => 1,
            //'category_id' => 1,
            //'brand_id' => 1,
        ]);
    }

    public function uniqueBy()
    {
        return 'sku';
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
