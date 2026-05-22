<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiBendingFg extends Model
{
    protected $fillable = [
        'inspeksi_bending_id',
        'user_id',
        'type',
        'coating_thickness',
        'daya_rekat',
        'visual',
        'packing',
        'label',
        'status',
        'qty',
        'weight',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
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
