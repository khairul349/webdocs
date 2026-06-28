<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center font-semibold text-sm transition-all disabled:opacity-25']) }}
    style="background: #fff; border: 1px solid #e4e8f2; color: #4a5068; padding: 10px 22px; border-radius: 10px; font-family: 'Inter', sans-serif; cursor: pointer;"
    onmouseover="this.style.background='#f4f6fb';"
    onmouseout="this.style.background='#fff';"
>
    {{ $slot }}
</button>