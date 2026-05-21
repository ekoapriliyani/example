<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiBending extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'pro_id',
        'product_fencing_ref_id',
        'shift',
        'mesin_id',
        'total_prod',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    public function pro()
    {
        return $this->belongsTo(Pro::class, 'pro_id');
    }

    public function productFencing()
    {
        return $this->belongsTo(ProductFencing::class, 'product_fencing_ref_id');
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    public function isApproved()
    {
        return $this->approval_status === 'APPROVED';
    }
}
