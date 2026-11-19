<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionframeFg extends Model
{
    protected $fillable = [
        'inspeksi_gabionframe_id',
        'user_id',
        'status',
        'qty',
        'weight',
        'packing',
        'label',
        'lot_number',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiGabionframe()
    {
        return $this->belongsTo(InspeksiGabionframe::class, 'inspeksi_gabionframe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionframeFgDetail::class, 'inspeksi_gabionframe_fg_id');
    }

    public function handlings()
    {
        return $this->hasMany(InspeksiGabionframeFgHandling::class, 'inspeksi_gabionframe_fg_id');
    }
}
