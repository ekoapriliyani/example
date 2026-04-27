<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiSheetGalvanize extends Model
{
    protected $fillable = [
        'tebal',
        'coating',
        'visual',
        'user_id',
    ];    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sheetgalvanize(){
        return $this->belongsTo(SheetGalvanize::class);
    }
}
