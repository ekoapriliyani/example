<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionframeFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_gabionframe_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiGabionframeFg()
    {
        return $this->belongsTo(InspeksiGabionframeFg::class, 'inspeksi_gabionframe_fg_id');
    }
}
