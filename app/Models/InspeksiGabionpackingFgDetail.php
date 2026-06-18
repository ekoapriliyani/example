<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionpackingFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_gabionpacking_fg_id',
        'description',
        'description2',
        'qty',
    ];
    public function inspeksiGabionpackingFg()
    {
        return $this->belongsTo(InspeksiGabionpackingFg::class, 'inspeksi_gabionpacking_fg_id');
    }
}
