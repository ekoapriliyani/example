<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionanyamWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_gabionanyam_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiGabionanyamWip()
    {
        return $this->belongsTo(InspeksiGabionanyamWip::class, 'inspeksi_gabionanyam_wip_id');
    }
}
