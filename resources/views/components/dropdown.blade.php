@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white/95 border border-emerald-100 text-emerald-900'
])

@php
    switch ($align) {
        case 'left':
            $alignmentClasses = 'origin-top-left left-0';
            break;
        case 'top':
            $alignmentClasses = 'origin-top';
            break;
        default:
            $alignmentClasses = 'origin-top-right right-0';
            break;
    }

    switch ($width) {
        case '48':
            $width = 'w-48';
            break;
        default:
            $width = 'w-48';
            break;
    }
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
    {{-- Trigger (nama Imelia Amanda) --}}
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    {{-- Panel dropdown --}}
    <div
        x-show="open"
        x-transition
        class="absolute z-50 mt-2 {{ $width }} rounded-xl shadow-lg {{ $alignmentClasses }}"
        style="display: none;"
    >
        <div class="rounded-xl bg-white/95 backdrop-blur {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
