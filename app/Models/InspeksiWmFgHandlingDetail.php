<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiWmFgHandlingDetail extends Model
{
    protected $fillable = [
        'handling_id',
        'status',
        'qty',
        'weight',
    ];

    public function handling()
    {
        return $this->belongsTo(InspeksiWmFgHandling::class, 'handling_id');
    }
}
