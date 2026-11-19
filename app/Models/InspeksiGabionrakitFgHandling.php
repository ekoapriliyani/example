<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionrakitFgHandling extends Model
{
    protected $fillable = [
        'inspeksi_gabionrakit_fg_id',
        'tanggal',
        'user_id',
        'catatan',
    ];

    public function inspeksiGabionrakitFg()
    {
        return $this->belongsTo(InspeksiGabionrakitFg::class, 'inspeksi_gabionrakit_fg_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionrakitFgHandlingDetail::class, 'handling_id');
    }
}
