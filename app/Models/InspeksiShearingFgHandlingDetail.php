<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiShearingFgHandlingDetail extends Model
{
    protected $fillable = [
        'handling_id',
        'status',
        'qty',
        'weight',
    ];

    public function handling()
    {
        return $this->belongsTo(InspeksiShearingFgHandling::class, 'handling_id');
    }
}
