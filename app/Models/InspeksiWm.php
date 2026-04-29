<?php

namespace App\Models;

use App\Models\InspeksiWmWip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiWm extends Model
{
    /** @use HasFactory<\Database\Factories\InspeksiWmFactory> */
    use HasFactory;
    protected $fillable = [
        'nomor_inspeksi',
        'pro_id',
        'product_wm_ref_id',
        'shift',
        'grade',
        'type_coating',
        'mesin_id',
    ];

    public function inspeksiWmWip() {
        return $this->hasMany(InspeksiWmWip::class);
    }

    public function inspeksiWmFg() {
        return $this->hasMany(InspeksiWmFg::class);
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }

    public function pro()
    {
        return $this->belongsTo(Pro::class);
    }

    public function productWm()
    {
        return $this->belongsTo(ProductWm::class, 'product_wm_ref_id');
    }
}