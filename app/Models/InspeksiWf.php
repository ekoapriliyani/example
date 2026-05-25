<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiWf extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'mesin_id',
        'total_prod',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function inspeksiWfWip()
    {
        return $this->hasMany(InspeksiWfWip::class);
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
