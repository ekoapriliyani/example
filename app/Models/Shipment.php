<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'shipment_id',
        'description',
        'custname',
        'qty',
    ];

    public function outgoings()
    {
        return $this->hasMany(Outgoing::class);
    }
}
