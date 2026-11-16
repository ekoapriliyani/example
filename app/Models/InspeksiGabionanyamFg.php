<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiGabionanyamFg extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspeksi_gabionanyam_id',
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

    public function inspeksiGabionanyam()
    {
        return $this->belongsTo(InspeksiGabionanyam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionanyamFgDetail::class);
    }

    public function handlings()
    {
        return $this->hasMany(InspeksiGabionanyamFgHandling::class);
    }
}
