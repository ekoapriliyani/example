<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiChainlink extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'mesin_id',
        'jml_lubang_p',
        'jml_counter',
        'jml_lubang_l',
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

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
