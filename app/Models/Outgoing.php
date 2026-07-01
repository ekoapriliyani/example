<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
    protected $fillable = [
        'tanggal',
        'nomor_inspeksi',
        'shipment_id',
        'lokasi',
        'no_kendaraan',
        'keterangan',
        'user_id',
        'files',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
