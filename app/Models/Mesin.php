<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    /** @use HasFactory<\Database\Factories\MesinFactory> */
    use HasFactory;
    protected $fillable = ['id_mesin', 'nama_mesin'];
    
}
