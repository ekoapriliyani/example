<?php

namespace App\Imports;

use App\Models\ProductCt;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProductCtImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ProductCt::create([
                'product_ct_id' => $row['product_ct_id'],
                'description'   => $row['description'],
                'd_kawat'       => $row['d_kawat'],
                'tol_d'         => $row['tol_d'],
                'p_product'     => $row['p_product'],
                'l_product'     => $row['l_product'],
                'l_mesh'        => $row['l_mesh'],
                'l2_mesh'        => $row['l2_mesh'],
                'p_mesh'        => $row['p_mesh'],
            ]);
        }
    }
}
