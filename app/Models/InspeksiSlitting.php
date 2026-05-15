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
        'total_prod',
        'mesin_id',
        'product_razor_ref_id',
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
        return $this->belongsTo(Mesin::class);
    }

    public function productRazor()
    {
        return $this->belongsTo(ProductRazor::class, 'product_razor_ref_id');
    }
}
