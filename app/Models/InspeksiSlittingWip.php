<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiSlittingWip extends Model
{
    protected $fillable = [
        'inspeksi_slitting_id',
        'user_id',
        'nama_operator',
        'l_sheetgalvanized',
        'tebal_sheetgalvanized',
        'visual',
        'status',
        'weight',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiSlitting()
    {
        return $this->belongsTo(InspeksiSlitting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiSlittingWipDetail::class);
    }
}
