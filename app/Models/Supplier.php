<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_code',
        'nama',
    ];

    public function incomingBahanBakus() {
        return $this->hasMany(IncomingBahanBaku::class);
    }
}
