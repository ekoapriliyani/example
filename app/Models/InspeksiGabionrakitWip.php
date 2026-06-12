<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionrakitWip extends Model
{
    protected $fillable = [
        'inspeksi_gabionrakit_id',
        'user_id',
        'no_material',
        'nama_operator',
        'p_act',
        'l_act',
        't_act',
        'type',
        'jml_sekat',
        'mesh1',
        'mesh2',
        'visual',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // Cast files as an array
    ];

    public function inspeksiGabionrakit()
    {
        return $this->belongsTo(InspeksiGabionrakit::class, 'inspeksi_gabionrakit_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionrakitWipDetail::class, 'inspeksi_gabionrakit_wip_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
