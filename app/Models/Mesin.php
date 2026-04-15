<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    /** @use HasFactory<\Database\Factories\MesinFactory> */
    use HasFactory;
    protected $fillable = ['mesin_id', 'nama_mesin'];
    
}
