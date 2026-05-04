<?php

namespace App\Imports;

use App\Models\ProductWm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductWmImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ProductWm([
            'jenis_wm'      => $row['jenis_wm'],
            'product_wm_id' => $row['product_wm_id'],
            'description'   => $row['description'],
            'd_kawat'       => $row['d_kawat'],
            'tol_d'         => $row['tol_d'],
            'p_product'     => $row['p_product'],
            'l_product'     => $row['l_product'],
            'p_mesh'        => $row['p_mesh'],
            'l_mesh'        => $row['l_mesh'],
            'tol_mesh'      => $row['tol_mesh'],
        ]);
    }
}