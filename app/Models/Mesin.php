<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    /** @use HasFactory<\Database\Factories\MesinFactory> */
    use HasFactory;
    protected $fillable = ['mesin_id', 'nama_mesin'];

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

    public function inspeksiKlips()
    {
        return $this->hasMany(InspeksiKlip::class);
    }
}
