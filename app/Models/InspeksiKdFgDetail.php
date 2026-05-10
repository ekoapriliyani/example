<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKdFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_kawat_duri_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiKawatDuriFg()
    {
        return $this->belongsTo(InspeksiKawatDuriFg::class);
    }
}
