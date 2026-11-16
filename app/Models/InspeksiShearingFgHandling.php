<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiShearingFgHandling extends Model
{
    protected $fillable = [
        'inspeksi_shearing_fg_id',
        'tanggal',
        'user_id',
        'catatan',
    ];

    public function inspeksiShearingFg()
    {
        return $this->belongsTo(InspeksiShearingFg::class, 'inspeksi_shearing_fg_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiShearingFgHandlingDetail::class, 'handling_id');
    }
}
