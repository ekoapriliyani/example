<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pro extends Model
{
    protected $fillable = [
        'pro_id',
        'description',
        'qty',
    ];

    public function inspeksiWms()
    {
        return $this->hasMany(InspeksiWm::class);
    }

    public function inspeksiKawatDuris()
    {
        return $this->hasMany(InspeksiKawatDuri::class);
    }


    public function inspeksiChainlinks()
    {
        return $this->hasMany(InspeksiChainlink::class);
    }

    public function inspeksiSlittings()
    {
        return $this->hasMany(InspeksiSlitting::class);
    }

    public function inspeksiPounds()
    {
        return $this->hasMany(InspeksiPound::class);
    }
}
