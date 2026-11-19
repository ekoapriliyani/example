<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionframeFgHandlingDetail extends Model
{
    protected $fillable = [
        'handling_id',
        'status',
        'qty',
        'weight',
    ];

    public function handling()
    {
        return $this->belongsTo(InspeksiGabionframeFgHandling::class, 'handling_id');
    }
}
