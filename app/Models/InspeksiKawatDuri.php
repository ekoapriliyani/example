<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKawatDuri extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'mesin_id',
        'type_coating',
    ];

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function pro()
    {
        return $this->belongsTo(Pro::class);
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }
}
