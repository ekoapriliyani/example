<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiWmFg extends Model
{
    /** @use HasFactory<\Database\Factories\InspeksiWmFgFactory> */
    use HasFactory;

    protected $fillable = [];

    public function inspeksiWm() {
        return $this->belongsTo(InspeksiWm::class);
    }
}
