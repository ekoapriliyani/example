<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiShearingFg extends Model
{
    protected $fillable = [
        'inspeksi_shearing_id',
        'user_id',
        'status',
        'qty',
        'weight',
        'packing',
        'label',
        'lot_number',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiShearing()
    {
        return $this->belongsTo(InspeksiShearing::class, 'inspeksi_shearing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiShearingFgDetail::class, 'inspeksi_shearing_fg_id');
    }

    public function handlings()
    {
        return $this->hasMany(InspeksiShearingFgHandling::class, 'inspeksi_shearing_fg_id');
    }
}
