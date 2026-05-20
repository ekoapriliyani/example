<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiRazorpackingFgDetail extends Model
{
    protected $fillable = [
        'inspeksi_razorpacking_fg_id',
        'description',
        'description2',
        'qty',
    ];

    // Relasi ke tabel utama
    public function inspeksiRazorpackingFg()
    {
        return $this->belongsTo(InspeksiRazorpackingFg::class);
    }
}
