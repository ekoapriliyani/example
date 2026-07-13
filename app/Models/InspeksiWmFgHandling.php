<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiWmFgHandling extends Model
{
    protected $fillable = [
        'inspeksi_wm_fg_id',
        'tanggal',
        'user_id',
        'catatan',
    ];

    public function inspeksiWmFg()
    {
        return $this->belongsTo(InspeksiWmFg::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiWmFgHandlingDetail::class, 'handling_id');
    }
}
