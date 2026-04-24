<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingBahanBakuInspeksi extends Model
{
    protected $fillable = [
        'incoming_bahan_baku_id',
        'diameter',
        'no_koil',
        'd1',
        'd2',
        'd3',
        'dimensi',
        'visual',
        'keterangan',
    ];

    public function incomingbahanbaku() {
        return $this->belongsTo(IncomingBahanBaku::class);
    }
}
