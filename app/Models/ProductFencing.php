<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFencing extends Model
{
    protected $fillable = [
        'product_fencing_id',
        'description',
        'd1',
        'd2',
        'tol_d1',
        'tol_d2',
        'p_before',
        'p_after',
        'l_before',
        'l_after',
    ];
}
