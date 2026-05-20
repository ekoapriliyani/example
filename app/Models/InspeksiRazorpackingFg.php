<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiRazorpackingFg extends Model
{
    protected $fillable = [
        'inspeksi_razorpacking_id',
        'user_id',
        'status',
        'qty',
        'weight',
        'visual',
        'label',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // Cast files sebagai array
    ];

    public function inspeksiRazorpacking()
    {
        return $this->belongsTo(InspeksiRazorpacking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiRazorpackingFgDetail::class);
    }
}
