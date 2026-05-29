<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingPvcHdpeInspeksi extends Model
{
    protected $fillable = [
        'incoming_pvc_hdpe_id',
        'user_id',
        'warna',
        'status',
        'keterangan',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
    ];

    public function incomingPvcHdpe()
    {
        return $this->belongsTo(IncomingPvcHdpe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
