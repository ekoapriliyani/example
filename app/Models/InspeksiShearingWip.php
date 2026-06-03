<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiShearingWip extends Model
{
    protected $fillable = [
        'inspeksi_shearing_id',
        'user_id',
        'no_material',
        'nama_operator',
        'p_potong',
        'l_potong',
        'type',
        'mesh1',
        'mesh2',
        'visual',
        'status',
        'files'
    ];

    protected $casts = [
        'files' => 'array', // Cast files as an array
    ];

    public function inspeksiShearing()
    {
        return $this->belongsTo(InspeksiShearing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiShearingWipDetail::class);
    }
}
