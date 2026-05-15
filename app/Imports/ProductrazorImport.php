<?php

namespace App\Imports;

use App\Models\ProductRazor;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductrazorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductRazor([
            //
        ]);
    }
}
