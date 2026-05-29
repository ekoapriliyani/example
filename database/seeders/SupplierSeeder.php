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
            ['supplier_code' => '001', 'nama' => 'PT Akino Wahana Mulia'],
            ['supplier_code' => '002', 'nama' => 'PT AM/NS'],
            ['supplier_code' => '003', 'nama' => 'PT Batraja'],
            ['supplier_code' => '004', 'nama' => 'PT Beka Wire Indonesia'],
            ['supplier_code' => '005', 'nama' => 'PT Bekaert'],
            ['supplier_code' => '006', 'nama' => 'PT Bekaert Qingdao'],
            ['supplier_code' => '007', 'nama' => 'PT Berondong'],
            ['supplier_code' => '008', 'nama' => 'PT Chin Herr'],
            ['supplier_code' => '009', 'nama' => 'PT First Cable'],
            ['supplier_code' => '010', 'nama' => 'PT Fumira'],
            ['supplier_code' => '011', 'nama' => 'PT Intiroda'],
            ['supplier_code' => '012', 'nama' => 'PT Ispat'],
            ['supplier_code' => '013', 'nama' => 'PT Metaropi'],
            ['supplier_code' => '014', 'nama' => 'PT Ngoc Minh'],
            ['supplier_code' => '015', 'nama' => 'PT Pratama'],
            ['supplier_code' => '016', 'nama' => 'PT QIDA'],
            ['supplier_code' => '017', 'nama' => 'PT SHANXI YUCI BROAD WIRE PRODUCTS CO., LTD'],
            ['supplier_code' => '018', 'nama' => 'PT Sinar Plastik'],
            ['supplier_code' => '019', 'nama' => 'PT TECHVANCE INDUSTRIES SDN BHD'],
            ['supplier_code' => '020', 'nama' => 'PT TSN Thailand'],
            ['supplier_code' => '021', 'nama' => 'PT Tumbak Mas'],
            ['supplier_code' => '022', 'nama' => 'PT Walsin'],
            ['supplier_code' => '023', 'nama' => 'PT Weidat'],
            ['supplier_code' => '024', 'nama' => 'PT Wiremesh Baja'],
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
