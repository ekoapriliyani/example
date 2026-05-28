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
        $now = now();
        $data = [
            ['supplier_code' => '001', 'nama' => 'PT Beka Wire Indonesia'],
            ['supplier_code' => '002', 'nama' => 'PT Bekaert'],
            ['supplier_code' => '003', 'nama' => 'PT Bumi Kaya Steel'],
            ['supplier_code' => '004', 'nama' => 'PT Tsn Wire'],
            ['supplier_code' => '005', 'nama' => 'PT Berondong Inti Perkasa'],
            ['supplier_code' => '006', 'nama' => 'PT Batraja Wirenindo Utama'],
            ['supplier_code' => '007', 'nama' => 'PT Qida Global'],
            ['supplier_code' => '008', 'nama' => 'PT Chin Herr'],
            ['supplier_code' => '009', 'nama' => 'PT Techvance Industries'],
            ['supplier_code' => '010', 'nama' => 'PT Ngoc Minh Steel'],
            ['supplier_code' => '011', 'nama' => 'PT AMNS'],
            ['supplier_code' => '012', 'nama' => 'PT Fumira'],
            ['supplier_code' => '013', 'nama' => 'PT Sinar Plastik'],
            ['supplier_code' => '014', 'nama' => 'PT Metropi Jaya'],
            ['supplier_code' => '015', 'nama' => 'PT Akini Wahanamulia'],
            ['supplier_code' => '016', 'nama' => 'PT First Cable'],
        ];

        $data = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $data);
        DB::table('suppliers')->insert($data);
    }
}
