<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiCtWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_ct_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiCtWip()
    {
        return $this->belongsTo(InspeksiCtWip::class);
    }
}
