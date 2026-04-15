<?php

namespace App\Models;

use App\Models\InspeksiWmWip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiWm extends Model
{
    /** @use HasFactory<\Database\Factories\InspeksiWmFactory> */
    use HasFactory;
    protected $fillable = ['nomor_inspeksi', 'trno', 'description', 'shift', 'grade', 'type_coating', 'shear_strength'];

    public function inspeksiWmWip() {
        return $this->hasMany(InspeksiWmWip::class);
    }

    public function inspeksiWmFg() {
        return $this->hasMany(InspeksiWmFg::class);
    }
}