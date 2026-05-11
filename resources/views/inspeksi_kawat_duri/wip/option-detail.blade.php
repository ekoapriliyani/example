@php
    $options = ['DIAMETER OUT', 'JARAK DURI', 'LILITAN', 'KARAT', 'WHITE RUST', 'CRACK', 'PANJANG OUT'];

@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
