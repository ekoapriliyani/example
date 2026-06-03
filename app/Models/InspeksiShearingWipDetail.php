<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiShearingWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_shearing_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiShearingWip()
    {
        return $this->belongsTo(InspeksiShearingWip::class, 'inspeksi_shearing_wip_id');
    }
}
