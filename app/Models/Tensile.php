<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tensile extends Model
{
    protected $fillable = [
        'incoming_bahan_baku_id',
        'user_id',
        'nilai_tensile',
    ];

    public function incomingBahanBaku()
    {
        return $this->belongsTo(IncomingBahanBaku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
