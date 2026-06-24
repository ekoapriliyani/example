<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiPvcWip extends Model
{
    protected $fillable = [
        'inspeksi_pvc_id',
        'user_id',
        'no_material',
        'nama_operator',
        'c1',
        'c2',
        'c3',
        'c4',
        'ch',
        'd_kawat_inti',
        'd_kawat_pvc',
        'penyimpangan',
        'warna',
        'uji_lilit',
        'visual',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiPvc()
    {
        return $this->belongsTo(InspeksiPvc::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiPvcWipDetail::class);
    }
}
