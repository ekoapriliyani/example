<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKawatDuriFg extends Model
{
    protected $fillable = [
        'inspeksi_kawat_duri_id',
        'user_id',
        'status',
        'qty',
        'weight',
        'files',
    ];

    public function inspeksiKawatDuri()
    {
        return $this->belongsTo(InspeksiKawatDuri::class, 'inspeksi_kawat_duri_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inspeksiKdFgDetails()
    {
        return $this->hasMany(InspeksiKdFgDetail::class, 'inspeksi_kawat_duri_fg_id');
    }
}
