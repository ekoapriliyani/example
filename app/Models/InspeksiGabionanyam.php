<?php

namespace App\Models;

use App\Models\InspeksiGabionanyamWip;
use Illuminate\Database\Eloquent\Model;

class InspeksiGabionanyam extends Model
{
    protected $table = 'inspeksi_gabionanyams';

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
        return $this->belongsTo(Pro::class, 'pro_id');
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function inspeksiGabionanyamWip()
    {
        return $this->hasMany(InspeksiGabionanyamWip::class);
    }
}
