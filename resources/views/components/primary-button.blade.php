<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center font-semibold text-sm text-white transition-all']) }}
    style="background: linear-gradient(135deg, #4f8ef7, #7c3aed); padding: 10px 22px; border-radius: 10px; border: none; box-shadow: 0 4px 16px rgba(79,142,247,0.35); font-family: 'Inter', sans-serif; cursor: pointer;"
    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 24px rgba(79,142,247,0.45)';"
    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(79,142,247,0.35)';"
>
    {{ $slot }}
</button>