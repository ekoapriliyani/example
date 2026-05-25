<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiCtWip extends Model
{
    protected $fillable = [
        'inspeksi_ct_id',
        'user_id',
        'no_material',
        'd_kawat_act',
        'nama_operator',
        'p_produk',
        'l_produk',
        't_produk',
        'mesh1',
        'mesh2',
        'mesh3',
        'diagonal',
        'visual',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiCt()
    {
        return $this->belongsTo(InspeksiCt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiCtWipDetail::class);
    }
}
