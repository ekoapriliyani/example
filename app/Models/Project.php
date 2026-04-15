<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'id_project', 
        'subkon_id',  
        'name',
        'no_pro',
        'qty',
    ];

    // relasi ke subkon
    public function subkon()
    {
        return $this->belongsTo(Subkon::class);
    }
}
