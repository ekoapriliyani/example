<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKawatDuriWip extends Model
{
    protected $fillable = [
        'inspeksi_kawat_duri_id',
        'user_id',
        'no_material',
        'nama_operator',
        'd_inti_kd',
        'd_pvc_kd',
        'd_inti_kj',
        'd_pvc_kj',
        'jarak_duri',
        'jml_jalinan_duri',
        'sudut_ujung_duri',
        'weight',
        'jml_counter',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiKawatDuri()
    {
        return $this->belongsTo(InspeksiKawatDuri::class, 'inspeksi_kawat_duri_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inspeksiKdWipDetails()
    {
        return $this->hasMany(InspeksiKdWipDetail::class, 'inspeksi_kawat_duri_wip_id');
    }
}
