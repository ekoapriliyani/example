<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiBendingWip extends Model
{
    protected $fillable = [
        'inspeksi_bending_id',
        'user_id',
        'no_material',
        'nama_operator',
        'd_kawat_act',
        'p_product_act',
        'l_product_act',
        't_tekukan',
        'mesh1',
        'mesh2',
        'mesh3',
        'mesh4',
        'mesh5',
        'diagonal',
        'matchingcrosswire',
        'visual',
        'status',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];


    public function inspeksiBending()
    {
        return $this->belongsTo(InspeksiBending::class, 'inspeksi_bending_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiBendingWipDetail::class, 'inspeksi_bending_wip_id');
    }
}
