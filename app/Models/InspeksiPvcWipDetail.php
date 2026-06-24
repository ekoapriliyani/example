<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiPvcWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_pvc_wip_id',
        'description',
        'description2',
        'qty',
    ];
}
