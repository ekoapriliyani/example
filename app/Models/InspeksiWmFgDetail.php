<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiWmFgDetail extends Model
{
    protected $fillable = ['inspeksi_wm_fg_id', 'description', 'qty'];

    public function inspeksiWmFg()
    {
        return $this->belongsTo(InspeksiWmFg::class);
    }

}
