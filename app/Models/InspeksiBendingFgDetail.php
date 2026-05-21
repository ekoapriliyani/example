<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiBendingFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_bending_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiBendingFg()
    {
        return $this->belongsTo(InspeksiBendingFg::class, 'inspeksi_bending_fg_id');
    }
}
