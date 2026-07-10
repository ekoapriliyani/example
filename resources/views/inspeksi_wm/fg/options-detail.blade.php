@php
    $options = [
        'CRACK/PEEL OFF/MENGELUPAS',
        'CW/LW PENDEK',
        'DIAGONAL OUT',
        'DIAMETER OUT',
        'KARAT',
        'LASAN LEPAS',
        'LEBAR OUT',
        'MESH OUT / TIDAK SIMETRIS',
        'OVERHANG OUT',
        'PANJANG OUT',
        'PATAH/PUTUS',
        'PENYOK/RUSAK',
        'SALAH TEKUK BENDING',
        'TINGGI OUT',
        'TRIMING',
        'WHITE RUST',
        'DOUBLE CROSS WIRE',
    ];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
