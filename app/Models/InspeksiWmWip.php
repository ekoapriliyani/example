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
            // 'd_kawat_act',
            // 'p_product_act',
            // 'l_product_act',
            // 'p_mesh',
            // 'l_mesh',
            // 'selisih_diagonal',
            // 'status_dimensi',
        ];

    public function inspeksiWm() {
        return $this->belongsTo(InspeksiWm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
