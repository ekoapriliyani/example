@props(['active' => false])

<a {{ $attributes->merge(['class' => $active ? 'text-teal-500 font-bold' : '']) }}>{{ $slot }}</a>
