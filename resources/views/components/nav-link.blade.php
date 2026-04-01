@props(['active' => false])

<a {{ $attributes }}>{{ $slot }} {{ $active }}</a>
