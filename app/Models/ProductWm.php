<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWm extends Model
{
    protected $fillable = [
        'jenis_wm',
        'product_wm_id',
        'description',
        'd_kawat',
        'tol_min_d',
        'tol_max_d',
        'p_product',
        'l_product',
        'p_mesh',
        'l_mesh',
        'tol_mesh',
    ];

    public function inspeksiWms()
    {
        return $this->hasMany(InspeksiWm::class, 'product_wm_ref_id');
    }
}
