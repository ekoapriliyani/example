<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionrakitFg extends Model
{
    protected $fillable = [
        'inspeksi_gabionrakit_id',
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

    public function inspeksiGabionrakit()
    {
        return $this->belongsTo(InspeksiGabionrakit::class, 'inspeksi_gabionrakit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionrakitFgDetail::class, 'inspeksi_gabionrakit_fg_id');
    }

    public function handlings()
    {
        return $this->hasMany(InspeksiGabionrakitFgHandling::class, 'inspeksi_gabionrakit_fg_id');
    }
}
