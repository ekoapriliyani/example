@php
    $options = [
        'LAS (LEPAS/TIDAK NGELAS)',
        'DIAMETER OUT',
        'TEBAL OUT',
        'PANJANG OUT',
        'LEBAR OUT',
        'TINGGI OUT',
        'DIAGONAL OUT',
        'CW/LW PENDEK',
        'MESH OUT / TIDAK SIMETRIS',
        'OVERHANG OUT',
        'KARAT',
        'WHITE RUST',
        'TRIMING',
        'CRACK',
        'PENYOK/RUSAK',
        'PVC/HDPE PECAH/SOBEK',
        'PVC/HDPE MIRING',
        'PVC/HDPE KASAR',
        'JARAK DURI/BLADE',
        'BLADE PECAH/SOBEK',
        'PISAU POUNCH TUMPUL',
        'BENDING TIDAK PRESS',
        'KLIP TIDAK RAPAT',
    ];
@endphp




<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
