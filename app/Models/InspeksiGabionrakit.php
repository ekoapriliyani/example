<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionrakit extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'diameter',
        'ukuran',
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

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function inspeksiGabionrakitWip()
    {
        return $this->hasMany(InspeksiGabionrakitWip::class, 'inspeksi_gabionrakit_id');
    }

    public function inspeksiGabionrakitFg()
    {
        return $this->hasMany(InspeksiGabionrakitFg::class, 'inspeksi_gabionrakit_id');
    }
}
