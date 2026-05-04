<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingProjectInspeksi extends Model
{
    protected $fillable = [
        'incoming_project_id',
        'user_id',
        'material_id',
        'visual',
        'files',
    ];
    protected $casts = [
        'files' => 'array', // otomatis decode JSON ke array saat diakses
    ];
    public function incomingproject()
    {
        return $this->belongsTo(IncomingProject::class, 'incoming_project_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
