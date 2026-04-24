<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['supplier_code' => '001', 'nama' => 'PT Beka Wire Indesia'],
            ['supplier_code' => '002', 'nama' => 'PT Bekaert'],
            ['supplier_code' => '003', 'nama' => 'PT Bumi Kaya'],
            ['supplier_code' => '004', 'nama' => 'TSN Wire'],
        ];
        DB::table('suppliers')->insert($data);
    }
}
