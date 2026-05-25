<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiWfWip extends Model
{
    protected $fillable = [
        'inspeksi_wf_id',
        'user_id',
        'no_material',
        'nama_operator',
        'd_kawat_act',
        'p_product_act',
        'visual',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiWf()
    {
        return $this->belongsTo(InspeksiWf::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiWfWipDetail::class);
    }
}
