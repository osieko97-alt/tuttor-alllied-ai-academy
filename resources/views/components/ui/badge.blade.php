@props([
    'kind' => 'default', // default, success, warning, danger, info, primary
    'size' => 'md',
])

@php
    $classes = 'badge';
    $classes .= ' badge-' . $kind;
    $classes .= ' badge-' . $size;
@endphp

<span class="{{ $classes }}">
    {{ $slot }}
</span>
