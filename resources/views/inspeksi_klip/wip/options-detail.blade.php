@php
    $options = ['KARAT', 'BENDING PECAH', 'POTONGAN TIDAK RAPI', 'KLIP TIDAK RAPAT'];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
