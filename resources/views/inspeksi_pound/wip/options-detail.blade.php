@php
    $options = ['KARAT', 'POTONGAN TIDAK RAPI'];
@endphp

<option value="">-- Pilih Detail --</option>

@foreach ($options as $option)
    <option value="{{ $option }}" {{ ($selected ?? null) == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
@endforeach
