@php
    $options = ['DIAMETER OUT', 'CRACK', 'MESH', 'PANJANG OUT', 'LEBAR OUT', 'WHITE RUST', 'DIAGONAL OUT'];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
