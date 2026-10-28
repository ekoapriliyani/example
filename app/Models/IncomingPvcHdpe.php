<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingPvcHdpe extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'supplier_id',
        'no_po',
        'no_sj',
        'certificate',
        'files',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function incomingPvcHdpeInspeksi()
    {
        return $this->hasMany(IncomingPvcHdpeInspeksi::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }
}
