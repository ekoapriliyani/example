<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKlipWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_klip_wip_id',
        'description',
        'description2',
        'qty'
    ];

    public function inspeksiKlipWip()
    {
        return $this->belongsTo(InspeksiKlipWip::class);
    }
}
