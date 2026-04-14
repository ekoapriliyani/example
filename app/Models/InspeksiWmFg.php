<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiWmFg extends Model
{
    /** @use HasFactory<\Database\Factories\InspeksiWmFgFactory> */
    use HasFactory;

    protected $fillable = [
        'inspeksi_wm_id',
        'user_id',
        'batch_number',
        'status',
        'qty',
    ];

    public function inspeksiWm() {
        return $this->belongsTo(InspeksiWm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
