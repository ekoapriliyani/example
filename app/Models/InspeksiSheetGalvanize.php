<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiSheetGalvanize extends Model
{
    protected $fillable = [
        'sheet_galvanize_id',
        'tebal',
        'coating',
        'visual',
        'user_id',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sheetgalvanize()
    {
        return $this->belongsTo(SheetGalvanize::class, 'sheet_galvanize_id');
    }
}
