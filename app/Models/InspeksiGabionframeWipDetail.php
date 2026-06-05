<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionframeWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_gabionframe_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiGabionframeWip()
    {
        return $this->belongsTo(InspeksiGabionframeWip::class, 'inspeksi_gabionframe_wip_id');
    }
}
