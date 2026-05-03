<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingPvcHdpe extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'supplier_id',
        'no_po',
        'no_sj',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
