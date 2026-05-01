<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SheetGalvanize extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'no_po',
        'supplier_id',
        'user_id',
        'tebal',
        'coating',
        'visual',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function inspeksiSheetGalvanizes()
    {
        return $this->hasMany(InspeksiSheetGalvanize::class, 'sheet_galvanize_id');
    }
}
