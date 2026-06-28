@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl shadow-sm w-full']) }}
    style="border: 1px solid #e4e8f2; padding: 10px 14px; font-family: 'Inter', sans-serif; font-size: 14px; color: #1a1f36; outline: none; transition: all 0.2s;"
    onfocus="this.style.borderColor='#4f8ef7'; this.style.boxShadow='0 0 0 3px rgba(79,142,247,0.12)';"
    onblur="this.style.borderColor='#e4e8f2'; this.style.boxShadow='none';"
>