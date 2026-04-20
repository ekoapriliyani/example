<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiWmWip extends Model
{
    /** @use HasFactory<\Database\Factories\InspeksiWmWipFactory> */
    use HasFactory;
    
    protected $fillable = [
            'inspeksi_wm_id', 
            'user_id', 
            'no_material', 
            'nama_operator',
            'd_kawat_act',
            'p_product_act',
            'l_product_act',
            'p_mesh_act',
            'l_mesh_act',
            'selisih_diagonal',
            'torsi_strength',
            'status_dimensi',
            'files',
        ];
    
    protected $casts = [
        'files' => 'array',
    ];

    public function inspeksiWm() {
        return $this->belongsTo(InspeksiWm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiWmWipDetail::class);
    }
}
