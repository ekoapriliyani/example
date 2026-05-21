<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKlipWip extends Model
{
    protected $fillable = [
        'inspeksi_klip_id',
        'user_id',
        'no_material',
        'nama_operator',
        'jml_klip',
        'd_razor',
        'jml_spiral',
        'jarak_antar_klip1',
        'jarak_antar_klip2',
        'jarak_antar_klip3',
        'jarak_antar_klip4',
        'jarak_antar_klip5',
        'kerapatan',
        'visual',
        'status',
        'files'
    ];

    protected $casts = [
        'files' => 'array', // Cast files as an array
    ];

    public function inspeksiKlip()
    {
        return $this->belongsTo(InspeksiKlip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiKlipWipDetail::class);
    }
}
