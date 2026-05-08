<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use App\Models\MechanicalTest;

class IncomingBahanBaku extends Model
{
    protected $fillable = [
        'tanggal',
        'nomor_inspeksi',
        'supplier_id',
        'no_po',
        'no_sj',
        'jml_koil',
        'd_kawat',
        'tol',
        'jenis_kawat',
        'certificate',
        'files',
    ];
    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function incomingbahanbakuinspeksi() {
        return $this->hasMany(IncomingBahanBakuInspeksi::class);
    }

    public function mechanicalTests()
    {
        return $this->hasMany(MechanicalTest::class, 'incoming_bahan_baku_id');
    }
}
