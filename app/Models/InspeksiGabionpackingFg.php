<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionpackingFg extends Model
{
    protected $fillable = [
        'inspeksi_gabionpacking_id',
        'user_id',
        'status',
        'qty',
        'weight',
        'visual',
        'label',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiGabionpacking()
    {
        return $this->belongsTo(InspeksiGabionpacking::class, 'inspeksi_gabionpacking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionpackingFgDetail::class, 'inspeksi_gabionpacking_fg_id');
    }
}
