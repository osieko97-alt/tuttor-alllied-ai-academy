@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
])

@php
    $classes = 'btn';
    $classes .= ' btn-' . $variant;
    $classes .= ' btn-' . $size;
    if ($disabled) $classes .= ' is-disabled';
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}" @disabled($disabled)>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $classes }}" @disabled($disabled)>
        {{ $slot }}
    </button>
@endif
