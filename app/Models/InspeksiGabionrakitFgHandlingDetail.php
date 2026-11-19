<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionrakitFgHandlingDetail extends Model
{
    protected $fillable = [
        'handling_id',
        'status',
        'qty',
        'weight',
    ];

    public function handling()
    {
        return $this->belongsTo(InspeksiGabionrakitFgHandling::class, 'handling_id');
    }
}
