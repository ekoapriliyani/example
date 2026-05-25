<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiWfWipDetail extends Model
{
    protected $fillable = ['inspeksi_wf_fg_id', 'description', 'description2', 'qty'];

    public function inspeksiWfWip()
    {
        return $this->belongsTo(InspeksiWfWip::class);
    }
}
