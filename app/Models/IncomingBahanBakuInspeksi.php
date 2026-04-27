<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingBahanBakuInspeksi extends Model
{
    protected $fillable = [
        'incoming_bahan_baku_id',
        'user_id',
        'no_koil',
        'd1',
        'd2',
        'd3',
        'rata_rata',
        'dimensi',
        'visual',
        'keterangan',
        'files',
    ];
    
    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
    ];

    public function incomingbahanbaku() {
        return $this->belongsTo(IncomingBahanBaku::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
