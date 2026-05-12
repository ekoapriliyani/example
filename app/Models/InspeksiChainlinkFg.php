<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiChainlinkFg extends Model
{
    protected $fillable = [
        'inspeksi_chainlink_id',
        'user_id',
        'status',
        'qty',
        'weight',
    ];

    public function inspeksiChainlink()
    {
        return $this->belongsTo(InspeksiChainlink::class, 'inspeksi_chainlink_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
