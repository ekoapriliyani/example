<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionanyamWip extends Model
{
    protected $fillable = [
        'inspeksi_gabionanyam_id',
        'user_id',
        'no_material',
        'nama_operator',
        'l1_act',
        'l2_act',
        'd_anyam',
        'd_frame',
        'd_anyam_pvc',
        'd_frame_pvc',
        'mesh1',
        'mesh2',
        'p_lilitan',
        'jml_lilitan',
        'visual',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // Cast files as an array
    ];

    public function inspeksiGabionanyam()
    {
        return $this->belongsTo(InspeksiGabionanyam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionanyamWipDetail::class, 'inspeksi_gabionanyam_wip_id');
    }
}
