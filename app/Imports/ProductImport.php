<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            Product::create([
                'brand_id' => $row['brand_id'] ?? 1,
                'product_name' => $row['product_name'],
                'description' => $row['description'],
                'price' => $row['price'],
                'stocks' => $row['stocks'],
                'category' => $row['category'],
                'img_path' => $row['img_path'],
            ]);
        }
    }
}
