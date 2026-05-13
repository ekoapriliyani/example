@php
    $options = ['CRACK', 'MESH', 'PANJANG OUT', 'LEBAR OUT', 'PVC PECAH', 'WHITE RUST'];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
