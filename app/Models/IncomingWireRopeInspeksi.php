<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingWireRopeInspeksi extends Model
{
    protected $fillable = [
        'incoming_wire_rope_id',
        'user_id',
        'no_koil',
        'd1_wire_rope',
        'd2_wire_rope',
        'd3_wire_rope',
        'd1_kawat_inti',
        'd2_kawat_inti',
        'd3_kawat_inti',
        'jml_kawat_inti',
        'dimensi',
        'visual',
        'description1',
        'description2',
        'lot_number',
        'files',
        'mechanical_user_id',
        'mechanical_status',
        'tensile_strength_kawat_inti',
        'mechanical_lot_number',
        'mechanical_files',
    ];

    protected $casts = [
        'files' => 'array',
        'mechanical_files' => 'array',
    ];

    public function incomingWireRope()
    {
        return $this->belongsTo(IncomingWireRope::class, 'incoming_wire_rope_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mechanicalUser()
    {
        return $this->belongsTo(User::class, 'mechanical_user_id');
    }
}
