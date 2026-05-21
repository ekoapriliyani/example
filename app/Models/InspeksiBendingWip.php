<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiBendingWip extends Model
{
    protected $fillable = [
        'inspeksi_bending_id',
        'user_id',
        'status',
        'qty',
        'weight',
        'files',
    ];

    public function inspeksiBending()
    {
        return $this->belongsTo(InspeksiBending::class, 'inspeksi_bending_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiBendingWipDetail::class, 'inspeksi_bending_wip_id');
    }
}
