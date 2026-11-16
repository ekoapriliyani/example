<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionanyamFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_gabionanyam_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiGabionanyamFg()
    {
        return $this->belongsTo(InspeksiGabionanyamFg::class);
    }
}
