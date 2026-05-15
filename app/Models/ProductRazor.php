<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRazor extends Model
{
    protected $fillable = [
        'product_razor_id',
        'description',
        'p_roll',
        'tol_min_roll',
        'tol_max_roll',
        'd_spiral',
        'tol_min_d_spiral',
        'tol_max_d_spiral',
        'd_kawat',
        'tol_min_d_kawat',
        'tol_max_d_kawat',
        'tebal_blade',
        'tol_min_tebal_blade',
        'tol_max_tebal_blade',
        'p_blade',
        'tol_min_p_blade',
        'tol_max_p_blade',
        'l_blade',
        'tol_min_l_blade',
        'tol_max_l_blade',
        'jarak_blade',
        'tol_min_jarak_blade',
        'tol_max_jarak_blade',
        'jml_spiral',
        'tol_min_jml_spiral',
        'tol_max_jml_spiral',
        'jml_klip_per_spiral',
        'jarak_antar_klip',
        'l_sheetgalvanized'
    ];
}
