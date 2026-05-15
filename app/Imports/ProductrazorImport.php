<?php

namespace App\Imports;

use App\Models\ProductRazor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProductrazorImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ProductRazor::create([
                'product_razor_id' => $row['product_razor_id'],
                'description'      => $row['description'],
                'p_roll'            => $row['p_roll'],
                'tol_min_p_roll'   => $row['tol_min_p_roll'],
                'tol_max_p_roll'   => $row['tol_max_p_roll'],
                'd_spiral'         => $row['d_spiral'],
                'tol_min_d_spiral' => $row['tol_min_d_spiral'],
                'tol_max_d_spiral' => $row['tol_max_d_spiral'],
                'd_kawat'         => $row['d_kawat'],
                'tol_min_d_kawat' => $row['tol_min_d_kawat'],
                'tol_max_d_kawat' => $row['tol_max_d_kawat'],
                'tebal_blade'         => $row['tebal_blade'],
                'tol_min_tebal_blade' => $row['tol_min_tebal_blade'],
                'tol_max_tebal_blade' => $row['tol_max_tebal_blade'],
                'p_blade'         => $row['p_blade'],
                'tol_min_p_blade' => $row['tol_min_p_blade'],
                'tol_max_p_blade' => $row['tol_max_p_blade'],
                'l_blade'         => $row['l_blade'],
                'tol_min_l_blade' => $row['tol_min_l_blade'],
                'tol_max_l_blade' => $row['tol_max_l_blade'],
                'jarak_blade'         => $row['jarak_blade'],
                'tol_min_jarak_blade' => $row['tol_min_jarak_blade'],
                'tol_max_jarak_blade' => $row['tol_max_jarak_blade'],
                'jml_spiral'         => $row['jml_spiral'],
                'tol_min_jml_spiral' => $row['tol_min_jml_spiral'],
                'tol_max_jml_spiral' => $row['tol_max_jml_spiral'],
                'jml_klip_per_spiral' => $row['jml_klip_per_spiral'],
                'jarak_antar_klip' => $row['jarak_antar_klip'],
                'l_sheetgalvanized' => $row['l_sheetgalvanized'],
            ]);
        }
    }
}
