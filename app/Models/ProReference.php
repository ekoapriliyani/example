<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProReference extends Model
{
    protected $fillable = [
        'trno',
        'description',
        'synced_at',
    ];
}
