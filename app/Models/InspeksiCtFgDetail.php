<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiCtFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_ct_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiCtFg()
    {
        return $this->belongsTo(InspeksiCtFg::class);
    }
}
