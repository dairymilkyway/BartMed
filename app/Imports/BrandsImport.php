<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Brand;

class BrandsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */ 
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            Brand::create([
                'brand_name' => $row['brand_name'],
                'img_path' => $row['img_path'],
            ]);
        }
    }
}
