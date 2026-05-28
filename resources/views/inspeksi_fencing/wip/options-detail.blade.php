@php
    $options = [
        'CRACK/PEEL OFF/MENGELUPAS',
        'CW/LW PENDEK',
        'DIAGONAL OUT',
        'DIAMETER OUT',
        'DROSS/KASAR/KOTORAN',
        'JARUMAN',
        'KARAT',
        'KLIP TIDAK RAPAT',
        'LASAN LEPAS',
        'LEBAR OUT',
        'MESH OUT / TIDAK SIMETRIS',
        'OVERHANG OUT',
        'PANJANG OUT',
        'PATAH/PUTUS',
        'PENYOK/RUSAK',
        'SALAH TEKUK BENDING',
        'SCRATCH',
        'TEBAL HOTDIP/POWDER COATING',
        'TINGGI OUT',
        'WHITE RUST',
    ];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
