<?php

namespace App\Imports;

use App\Models\ProductFencing;
use App\Models\ProductWm;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductFencingImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ProductFencing::create([
                'product_fencing_id' => $row['product_fencing_id'],
                'description'        => $row['description'],
                'd1'            => $row['d1'],
                'd2'            => $row['d2'],
                'tol_d1'            => $row['tol_d1'],
                'tol_d2'            => $row['tol_d2'],
                'p_before'            => $row['p_before'],
                'p_after'            => $row['p_after'],
                'l_before'            => $row['l_before'],
                'l_after'            => $row['l_after'],
            ]);
        }
    }
}
