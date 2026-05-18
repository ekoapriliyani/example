<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCt extends Model
{
    protected $fillable = [
        'product_ct_id',
        'description',
        'd_kawat',
        'tol_d',
        'p_product',
        'l_product',
        'l_mesh',
        'l2_mesh',
        'p_mesh',
    ];

    public function inspeksiCts()
    {
        return $this->hasMany(InspeksiCt::class, 'product_ct_ref_id');
    }
}
