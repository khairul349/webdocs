@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm']) }} style="color: #1a1f36; font-family: 'Inter', sans-serif;">
    {{ $value ?? $slot }}
</label>