<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiSlitting extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'shift',
        'l_sheetgalvanized',
        'tebal_sheetgalvanized',
        'visual',
        'weight',
        'total_prod',
        'approval_status',
        'approved_by',
        'approved_at'
    ];

    public function pro()
    {
        return $this->belongsTo(Pro::class, 'pro_id');
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    public function productRazor()
    {
        return $this->belongsTo(ProductRazor::class, 'product_razor_ref_id');
    }
}
