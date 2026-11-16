<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionanyamFgHandlingDetail extends Model
{
    protected $fillable = [
        'handling_id',
        'status',
        'qty',
        'weight',
    ];

    public function handling()
    {
        return $this->belongsTo(InspeksiGabionanyamFgHandling::class, 'handling_id');
    }
}
