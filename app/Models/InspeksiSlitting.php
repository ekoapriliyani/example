<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiSlitting extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'ukuran',
        'shift',
        'total_prod',
        'satuan',
        'mesin_id',
        'approval_status',
        'approved_by',
        'approved_at'
    ];

    public function inspeksiSlittingWip()
    {
        return $this->hasMany(InspeksiSlittingWip::class);
    }

    public function pro()
    {
        return $this->belongsTo(Pro::class, 'pro_id');
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }
}
