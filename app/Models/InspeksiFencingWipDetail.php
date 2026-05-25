<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiFencingWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_fencing_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiFencingWip()
    {
        return $this->belongsTo(InspeksiFencingWip::class, 'inspeksi_fencing_wip_id');
    }
}
