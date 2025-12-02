@props(['as' => 'a'])

@php
$classes = 'block w-full px-4 py-2 text-start text-sm leading-5
            text-emerald-800 hover:text-emerald-900
            hover:bg-emerald-50 focus:outline-none focus:bg-emerald-50 transition';
@endphp

@if ($as === 'button')
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@endif
