<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiShearing extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'mesin_id',
        'total_prod',
        'satuan',
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

    public function inspeksiShearingWip()
    {
        return $this->hasMany(InspeksiShearingWip::class);
    }

    public function inspeksiShearingFg()
    {
        return $this->hasMany(InspeksiShearingFg::class);
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }
}
