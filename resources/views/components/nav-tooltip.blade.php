@props(['label'])

{{--
    Tooltip nama menu yang muncul saat di-hover (desktop).
    Harus dipakai di dalam elemen yang juga punya class "group" + "relative".
    Posisi di bawah tombol; jika dropdown terbuka, menu (z-50, setelah ini di DOM)
    menimpa tooltip sehingga tidak tumpang tindih.
--}}
<span {{ $attributes->merge(['class' => 'pointer-events-none absolute left-1/2 top-full z-50 mt-1.5 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-900 px-2 py-1 text-xs font-medium text-white opacity-0 shadow-lg transition-opacity duration-150 group-hover:opacity-100']) }} aria-hidden="true">{{ $label }}</span>
