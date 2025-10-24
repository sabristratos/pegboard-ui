<div
    :data-active="isActive('{{ $name }}')"
    class="hidden data-[active=true]:block"
    role="tabpanel"
    :aria-hidden="!isActive('{{ $name }}')"
    data-pegboard-tab-panel
    data-tab-name="{{ $name }}"
    {{ $attributes }}
>
    {{ $slot }}
</div>
