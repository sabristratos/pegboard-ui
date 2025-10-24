@php
    $baseClasses = 'flex items-center gap-2 w-full px-3 py-2 text-sm rounded cursor-pointer transition-colors duration-fast outline-none';
    $variantClasses = [
        'default' => 'text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground data-[active]:bg-popover-hover data-[active]:text-popover-hover-foreground active:bg-popover-hover/90',
        'danger' => 'text-destructive hover:bg-destructive/10 hover:text-destructive data-[active]:bg-destructive/10 data-[active]:text-destructive active:bg-destructive/20',
    ];
    $disabledClasses = 'opacity-50 cursor-not-allowed pointer-events-none';
@endphp

<button
    type="button"
    x-data="menuItem({ disabled: {{ $disabled ? 'true' : 'false' }}, keepOpen: {{ $keepOpen ? 'true' : 'false' }} })"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses[$variant] . ($disabled ? ' ' . $disabledClasses : '')]) }}
>
    @if($icon)
        <x-pegboard::icon :name="$icon" :variant="$iconVariant" class="h-4 w-4 shrink-0" />
    @endif

    <span class="flex-1 text-left">
        {{ $slot }}
    </span>

    @if($kbd)
        <kbd class="hidden sm:inline-flex h-5 select-none items-center gap-1 rounded border border-border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground opacity-100">
            {{ $kbd }}
        </kbd>
    @endif

    @if($suffix)
        <span class="text-xs text-muted-foreground">
            {{ $suffix }}
        </span>
    @endif

    @if($iconTrailing)
        <x-pegboard::icon :name="$iconTrailing" :variant="$iconVariant" class="h-4 w-4 shrink-0" />
    @endif
</button>
