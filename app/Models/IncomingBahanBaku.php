<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class IncomingBahanBaku extends Model
{
    protected $fillable = [
        'tanggal',
        'supplier_id',
        'no_po',
        'no_sj',
        'jml_koil',
        'd_kawat',
        'tol',
        'jenis_kawat',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function incomingbahanbakuinspeksi() {
        return $this->hasMany(IncomingBahanBakuInspeksi::class);
    }
}
