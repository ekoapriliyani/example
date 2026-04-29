<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiWmWipDetail extends Model
{
    protected $fillable = ['inspeksi_wm_wip_id', 'description', 'qty'];
    
    public function inspeksiWmWip()
    {
        return $this->belongsTo(InspeksiWmWip::class);
    }
}
