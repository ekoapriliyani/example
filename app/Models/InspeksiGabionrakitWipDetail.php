<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionrakitWipDetail extends Model
{
    protected $fillable = [
        'inspeksi_gabionrakit_wip_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiGabionrakitWip()
    {
        return $this->belongsTo(InspeksiGabionrakitWip::class, 'inspeksi_gabionrakit_wip_id');
    }
}
