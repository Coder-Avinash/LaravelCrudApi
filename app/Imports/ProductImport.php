<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([

            'title'     => $row['title'],
            'description'    => $row['description'], 
            'price' => $row['price'],
            'type' => $row['type'],
            'is_active' => $row['is_active'],
            
        ]);
    }
}
