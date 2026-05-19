<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiPoundWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_pound_wip_id',
        'description',
        'description2',
        'qty'
    ];

    public function inspeksiPoundWip()
    {
        return $this->belongsTo(InspeksiPoundWip::class);
    }
}
