<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKdWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_kawat_duri_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiKawatDuriWip()
    {
        return $this->belongsTo(InspeksiKawatDuriWip::class, 'inspeksi_kawat_duri_wip_id');
    }
}
