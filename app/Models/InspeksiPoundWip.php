<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiPoundWip extends Model
{
    protected $fillable = [
        'inspeksi_pound_id',
        'user_id',
        'no_material',
        'nama_operator',
        'tebal_blade',
        'p_blade',
        'l_blade',
        'jarak_blade',
        'jml_spiral',
        'd_roll',
        'daya_jepit',
        'visual',
        // 'weight',
        'status',
        'files'
    ];

    protected $casts = [
        'files' => 'array', // Cast files as an array
    ];

    public function inspeksiPound()
    {
        return $this->belongsTo(InspeksiPound::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiPoundWipDetail::class);
    }
}
