@props([
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'label' => null,
    'error' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
])

<div style="margin-bottom: var(--space-4);">
    @if($label)
        <label for="{{ $name }}" style="display: block; font-weight: var(--font-semibold); margin-bottom: var(--space-2);">
            {{ $label }}
            @if($required)
                <span style="color: var(--danger);">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @class(['input', 'input-error' => $error])
        @disabled($disabled)
        @readonly($readonly)
        @required($required)
    >

    @if($error)
        <div style="color: var(--danger); font-size: var(--text-sm); margin-top: var(--space-1);">
            {{ $error }}
        </div>
    @endif

    @error($name)
        <div style="color: var(--danger); font-size: var(--text-sm); margin-top: var(--space-1);">
            {{ $message }}
        </div>
    @enderror
</div>
