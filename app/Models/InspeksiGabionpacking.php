<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionpacking extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'total_prod',
        'satuan',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    public function pro()
    {
        return $this->belongsTo(Pro::class, 'pro_id');
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function inspeksiGabionpackingFg()
    {
        return $this->hasMany(InspeksiGabionpackingFg::class, 'inspeksi_gabionpacking_id');
    }
}
