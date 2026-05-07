<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MechanicalTest extends Model
{
    protected $fillable = [
        'incoming_bahan_baku_id',
        'user_id',
        'nomor_koil',
        'hasil_tensile',
        'hasil_coatingweight',
        'hasil_lilit',
        'hasil_puntir',
    ];

    public function incomingBahanBaku() {
        return $this->belongsTo(IncomingBahanBaku::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
