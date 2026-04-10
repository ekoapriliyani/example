<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Tambahkan ini

class MaterialImport implements ToModel, WithHeadingRow // Tambahkan WithHeadingRow
{
    public function model(array $row)
    {
        return new Material([
            // Sekarang kamu panggil berdasarkan nama kolom di Excel (huruf kecil & snake_case)
            'item_id'     => $row['item_id'], 
            'description' => $row['description'],
        ]);
    }
}