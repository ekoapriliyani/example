<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiSlittingWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_slitting_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiSlittingWip()
    {
        return $this->belongsTo(InspeksiSlittingWip::class);
    }
}
