<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingInspeksi extends Model
{
    protected $table = 'outgoing_inspeksis';

    protected $fillable = [
        'outgoing_id',
        'user_id',
        'label',
        'karat',
        'penyok',
        'kotor',
        'galvanized',
        'lasan',
        'mesh',
        'pvc',
        'packing',
        'qty',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // Laravel otomatis mengubah Array <-> JSON string di database
    ];

    public function outgoing()
    {
        return $this->belongsTo(Outgoing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
