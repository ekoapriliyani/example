<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LksDetail extends Model
{
    protected $fillable = [
        'lks_id',
        'lot_number',
        'sumber',
        'sumber_id',
        'no_koil',
        'status',
        'description1',
        'description2',
        'tanggal_inspeksi',
    ];

    public function lks()
    {
        return $this->belongsTo(Lks::class);
    }
}
