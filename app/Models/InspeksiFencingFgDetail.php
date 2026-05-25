<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiFencingFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_fencing_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiFencingFg()
    {
        return $this->belongsTo(InspeksiFencingFg::class, 'inspeksi_fencing_fg_id');
    }
}
