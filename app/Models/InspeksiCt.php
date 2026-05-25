<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiCt extends Model
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

    public function pro()
    {
        return $this->belongsTo(Pro::class);
    }


    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }

    public function inspeksiCtWip()
    {
        return $this->hasMany(InspeksiCtWip::class);
    }

    public function inspeksiCtFg()
    {
        return $this->hasMany(InspeksiCtFg::class);
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }
}
