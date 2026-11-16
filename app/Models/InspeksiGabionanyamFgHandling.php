<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionanyamFgHandling extends Model
{
    protected $fillable = [
        'inspeksi_gabionanyam_fg_id',
        'tanggal',
        'user_id',
        'catatan',
    ];

    public function inspeksiGabionanyamFg()
    {
        return $this->belongsTo(InspeksiGabionanyamFg::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionanyamFgHandlingDetail::class, 'handling_id');
    }
}
