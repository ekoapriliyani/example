<?php

namespace App\Models;

use App\Models\InspeksiGabionframeWipDetail;
use Illuminate\Database\Eloquent\Model;

class InspeksiGabionframeWip extends Model
{
    protected $fillable = [
        'inspeksi_gabionframe_id',
        'user_id',
        'no_material',
        'nama_operator',
        'p_act',
        'l_act',
        't_act',
        'd_kwtGal_anyam',
        'd_kwtGal_frame',
        'd_kwtPvc_anyam',
        'd_kwtPvc_frame',
        'mesh1',
        'mesh2',
        'visual',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // Cast files as an array
    ];

    public function inspeksiGabionframe()
    {
        return $this->belongsTo(InspeksiGabionframe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionframeWipDetail::class, 'inspeksi_gabionframe_wip_id');
    }
}
