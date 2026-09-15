<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lks extends Model
{
    protected $fillable = [
        'nomor_lks',
        'supplier_id',
        'tanggal',
        'keterangan',
        'status',
        'approved_by',
        'approved_at',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
        'approved_at' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(LksDetail::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isApproved(): bool
    {
        return $this->status === 'APPROVED';
    }

    public function isClosed(): bool
    {
        return $this->status === 'CLOSED';
    }

    public function isDraft(): bool
    {
        return $this->status === 'DRAFT';
    }
}
