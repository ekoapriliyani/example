<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiCtFg extends Model
{
    protected $fillable = [
        'inspeksi_ct_id',
        'user_id',
        'status',
        'packing',
        'label',
        'qty',
        'weight',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiCt()
    {
        return $this->belongsTo(InspeksiCt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
