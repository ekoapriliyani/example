<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiChainlinkFg extends Model
{
    protected $fillable = [
        'inspeksi_chainlink_id',
        'user_id',
        'status',
        'packing',
        'label',
        'qty',
        'weight',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
    ];

    public function inspeksiChainlink()
    {
        return $this->belongsTo(InspeksiChainlink::class, 'inspeksi_chainlink_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inspeksiChainlinkFgDetails()
    {
        return $this->hasMany(InspeksiChainlinkFgDetail::class, 'inspeksi_chainlink_fg_id');
    }
}
