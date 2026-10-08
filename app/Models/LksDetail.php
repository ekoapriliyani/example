<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LksDetail extends Model
{
    protected $fillable = [
        'lks_id',
        'lot_number',
        'sumber',
        'sumber_id',
        'no_koil',
        'status',
        'description1',
        'description2',
        'tanggal_inspeksi',
    ];

    public function lks()
    {
        return $this->belongsTo(Lks::class);
    }

    public function sumberInspeksi()
    {
        return $this->belongsTo(IncomingBahanBakuInspeksi::class, 'sumber_id');
    }

    public function sumberMechanical()
    {
        return $this->belongsTo(MechanicalTest::class, 'sumber_id');
    }

    private function incomingBahanBaku(): ?IncomingBahanBaku
    {
        if ($this->sumber === 'inspeksi') {
            return $this->sumberInspeksi?->incomingbahanbaku;
        }

        return $this->sumberMechanical?->incomingBahanBaku;
    }

    public function getNoPoAttribute(): ?string
    {
        return $this->incomingBahanBaku()?->no_po;
    }

    public function getNoRcrAttribute(): ?string
    {
        return $this->incomingBahanBaku()?->no_rcr;
    }

    public function getDescriptionBarangAttribute(): ?string
    {
        return $this->incomingBahanBaku()?->description;
    }
}
