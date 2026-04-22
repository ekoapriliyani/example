<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pro extends Model
{
    protected $fillable = [
        'pro_id',
        'description',
        'qty',
    ];

    public function inspeksiWms()
    {
        return $this->hasMany(InspeksiWm::class);
    }
}