<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingWireRope extends Model
{
    protected $fillable = [
        'tanggal',
        'jenis',
        'nomor_inspeksi',
        'supplier_id',
        'no_rcr',
        'description',
        'no_po',
        'no_sj',
        'jml_koil',
        'd_kawat',
        'tol',
        'jenis_kawat',
        'certificate',
        'files',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function inspeksis()
    {
        return $this->hasMany(IncomingWireRopeInspeksi::class);
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
