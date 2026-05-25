<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiFencingFg extends Model
{
    protected $fillable = [
        'inspeksi_fencing_id',
        'user_id',
        'type',
        'coating_thickness',
        'daya_rekat',
        'visual',
        'packing',
        'label',
        'status',
        'qty',
        'weight',
        'files',
    ];

    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array
    ];

    public function inspeksiFencing()
    {
        return $this->belongsTo(InspeksiFencing::class, 'inspeksi_fencing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiFencingFgDetail::class, 'inspeksi_fencing_fg_id');
    }
}
