<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionrakitFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_gabionrakit_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiGabionrakitFg()
    {
        return $this->belongsTo(InspeksiGabionrakitFg::class, 'inspeksi_gabionrakit_fg_id');
    }
}
