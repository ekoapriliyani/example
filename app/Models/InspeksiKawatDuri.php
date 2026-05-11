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
        'total_prod',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    public function inspeksiKawatDuriWip()
    {
        return $this->hasMany(InspeksiKawatDuriWip::class, 'inspeksi_kawat_duri_id');
    }

    public function inspeksiKawatDuriFg()
    {
        return $this->hasMany(InspeksiKawatDuriFg::class, 'inspeksi_kawat_duri_id');
    }

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
