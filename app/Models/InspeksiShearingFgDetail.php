<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiShearingFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_shearing_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiShearingFg()
    {
        return $this->belongsTo(InspeksiShearingFg::class, 'inspeksi_shearing_fg_id');
    }
}
