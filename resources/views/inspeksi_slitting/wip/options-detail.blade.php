@php
    $options = [
        'BENDING TIDAK PRESS',
        'BLADE PECAH/SOBEK',
        'CRACK/PEEL OFF/MENGELUPAS',
        'DIAMETER OUT',
        'JARAK DURI/BLADE',
        'JUMLAH SPIRAL OUT',
        'KARAT',
        'KLIP TIDAK RAPAT',
        'LEBAR BLADE OUT',
        'PANJANG BLADE OUT',
        'PATAH/PUTUS',
        'PENYOK/RUSAK',
        'PISAU POUNCH TUMPUL',
        'TEBAL BLADE OUT',
        'TRIMING',
        'WHITE RUST',
    ];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
