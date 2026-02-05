@props([
    'value' => 0, // 0-100
    'size' => 'md', // sm, md, lg
    'showLabel' => false,
])

@php
    $percent = max(0, min(100, (int) $value));
    $classes = 'progress';
    $classes .= ' progress-' . $size;
@endphp

<div class="{{ $classes }}" role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar" style="width: {{ $percent }}%;"></div>
</div>

@if($showLabel)
    <span class="text-small text-muted">{{ $percent }}%</span>
@endif
