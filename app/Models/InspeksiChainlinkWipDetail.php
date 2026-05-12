<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiChainlinkWipDetail extends Model
{
    protected $fillable = ['inspeksi_wm_fg_id', 'description', 'description2', 'qty'];

    public function inspeksiChainlinkWip()
    {
        return $this->belongsTo(InspeksiChainlinkWip::class);
    }
}
