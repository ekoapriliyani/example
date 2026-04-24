<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class IncomingBahanBaku extends Model
{
    protected $fillable = [
        'tanggal',
        'supplier_id',
        'no_pro',
        'no_sj',
        'jml_koil',
        'd_kawat',
        'tol',
        'jenis_kawat',
        'mulai',
        'selesai',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
