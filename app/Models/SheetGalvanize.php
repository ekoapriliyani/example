<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SheetGalvanize extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'no_po',
        'no_sj',
        'certificate',
        'files',
        'supplier_id',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function inspeksiSheetGalvanizes()
    {
        return $this->hasMany(InspeksiSheetGalvanize::class, 'sheet_galvanize_id');
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
