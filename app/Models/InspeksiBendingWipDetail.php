<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiBendingWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_bending_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiBendingWip()
    {
        return $this->belongsTo(InspeksiBendingWip::class, 'inspeksi_bending_wip_id');
    }
}
