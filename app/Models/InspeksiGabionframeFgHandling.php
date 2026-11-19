<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiGabionframeFgHandling extends Model
{
    protected $fillable = [
        'inspeksi_gabionframe_fg_id',
        'tanggal',
        'user_id',
        'catatan',
    ];

    public function inspeksiGabionframeFg()
    {
        return $this->belongsTo(InspeksiGabionframeFg::class, 'inspeksi_gabionframe_fg_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InspeksiGabionframeFgHandlingDetail::class, 'handling_id');
    }
}
