<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingDefect extends Model
{
    protected $table = 'outgoing_defects';

    /**
     * Opsi defect untuk dropdown problem1 & problem2.
     * Silakan sesuaikan daftar ini ketika data master defect sudah tersedia.
     */
    public const PROBLEM_OPTIONS = [
        'Berkarat',
        'Penyok',
        'Kotor/Hitam',
        'Galvanized Pecah',
        'Lasan Lepas',
        'Mesh Rusak',
        'PVC Sobek',
        'Packing Rusak',
        'Label Rusak',
        'Ukuran Tidak Sesuai',
        'Lainnya',
    ];

    protected $fillable = [
        'outgoing_id',
        'user_id',
        'jml_ng',
        'problem1',
        'problem2',
        'foto',
    ];

    protected $casts = [
        'foto' => 'array', // Laravel otomatis mengubah Array <-> JSON string di database
    ];

    public function outgoing()
    {
        return $this->belongsTo(Outgoing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
