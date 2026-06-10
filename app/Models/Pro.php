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

    public function inspeksiBendings()
    {
        return $this->hasMany(InspeksiBending::class);
    }

    public function inspeksiWfs()
    {
        return $this->hasMany(InspeksiWf::class);
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

    public function inspeksiCts()
    {
        return $this->hasMany(InspeksiCt::class);
    }

    public function inspeksiRazorpackings()
    {
        return $this->hasMany(InspeksiRazorpacking::class);
    }

    public function inspeksiGabionframes()
    {
        return $this->hasMany(InspeksiGabionframe::class);
    }

    public function inspeksiGabionanyams()
    {
        return $this->hasMany(InspeksiGabionanyam::class);
    }
}
