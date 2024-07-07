<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Product;
class ProductsImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            Product::create([
                'brand_id' => $row[0],
                'product_name' => $row[1],
                'description' => $row[2],
                'price' => $row[3],
                'stocks' => $row[4],
                'category' => $row[5],
                'img_path' => $row[6],
                
            ]);
        }
    }
}
