@php
    $options = [
        'CRACK/PEEL OFF/MENGELUPAS',
        'DIAMETER OUT',
        'JARAK DURI/BLADE',
        'KARAT',
        'PANJANG OUT',
        'PATAH/PUTUS',
        'PENYOK/RUSAK',
        'PVC/HDPE KASAR',
        'PVC/HDPE MIRING',
        'PVC/HDPE PECAH/SOBEK',
        'WHITE RUST',
    ];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
