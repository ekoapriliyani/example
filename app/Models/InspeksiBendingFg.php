<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiBendingFg extends Model
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
        return $this->hasMany(InspeksiBendingFgDetail::class, 'inspeksi_bending_fg_id');
    }
}
