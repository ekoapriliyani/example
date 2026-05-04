<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductWmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $data = [
            ['jenis_wm' => 'Roll', 
            'product_wm_id' => '3315L', 
            'description' => '3315L', 
            'd_kawat' => 1.6, 
            'tol_d' => 0.05,
            'p_product' => 30000,
            'l_product' => 1800,
            'p_mesh' => 75,
            'l_mesh' => 75,
            'tol_mesh' => 2], 
        ];

        $data = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $data);

        DB::table('product_wms')->insert($data);
        }
    }
