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

    public function inspeksiFencings()
    {
        return $this->hasMany(InspeksiFencing::class);
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

    public function inspeksiRazorpackings()
    {
        return $this->hasMany(InspeksiRazorpacking::class);
    }

    public function inspeksiCts()
    {
        return $this->hasMany(InspeksiCt::class);
    }

    public function inspeksiGabionframes()
    {
        return $this->hasMany(InspeksiGabionframe::class);
    }

    public function inspeksiGabionanyams()
    {
        return $this->hasMany(InspeksiGabionanyam::class);
    }

    public function inspeksiGabionrakits()
    {
        return $this->hasMany(Gabionrakit::class);
    }
}
