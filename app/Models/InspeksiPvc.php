<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiPvc extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'mesin_id',
        'd_kawat_inti',
        'toleransi',
        'c1',
        'c2',
        'c3',
        'c4',
        'ch',
        'total_prod',
        'satuan',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }

    public function pro()
    {
        return $this->belongsTo(Pro::class);
    }
}
