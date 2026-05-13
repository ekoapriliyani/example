<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiChainlinkWip extends Model
{
    protected $fillable = [
        'inspeksi_chainlink_id',
        'user_id',
        'no_material',
        'nomor_inspeksi',
        'nama_operator',
        'lebar',
        'panjang',
        'mesh',
        'diameter_inti',
        'diameter_luar',
        'type',
        'model',
        'warna',
        'visual',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiChainlink()
    {
        return $this->belongsTo(InspeksiChainlink::class, 'inspeksi_chainlink_id');
    }

    public function pro()
    {
        return $this->belongsTo(Pro::class);
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inspeksiChainlinkWipDetails()
    {
        return $this->hasMany(InspeksiChainlinkWipDetail::class, 'inspeksi_chainlink_wip_id');
    }
}
