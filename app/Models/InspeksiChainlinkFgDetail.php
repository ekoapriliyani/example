<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiChainlinkFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_chainlink_fg_id',
        'description',
        'description2',
        'qty',
    ];

    public function inspeksiChainlinkFg()
    {
        return $this->belongsTo(InspeksiChainlinkFg::class);
    }
}
