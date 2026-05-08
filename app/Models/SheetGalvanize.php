<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SheetGalvanize extends Model
{
    protected $fillable = [
        'nomor_inspeksi',
        'tanggal',
        'no_po',
        'no_sj',
        'certificate',
        'files',
        'supplier_id',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function inspeksiSheetGalvanizes()
    {
        return $this->hasMany(InspeksiSheetGalvanize::class, 'sheet_galvanize_id');
    }
}
