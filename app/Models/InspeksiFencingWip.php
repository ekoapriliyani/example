<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiFencingWip extends Model
{
    protected $fillable = [
        'inspeksi_fencing_id',
        'user_id',
        'no_material',
        'nama_operator',
        'd_kawat_act',
        'p_product_act',
        'l_product_act',
        't_product_act',
        'mesh1',
        'mesh2',
        'mesh3',
        'mesh4',
        'mesh5',
        'mesh6',
        'diagonal',
        'shear_strength',
        'overhang',
        'matchingcrosswire',
        'visual',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];


    public function inspeksiFencing()
    {
        return $this->belongsTo(InspeksiFencing::class, 'inspeksi_fencing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiFencingWipDetail::class, 'inspeksi_fencing_wip_id');
    }
}
