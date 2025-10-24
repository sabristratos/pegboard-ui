@php
    $baseClasses = 'min-w-56 bg-popover text-popover-foreground border border-border rounded-lg shadow-lg p-1 flex flex-col gap-1 overflow-hidden origin-center transition-[opacity,transform,overlay,display] duration-fast ease-out transition-discrete starting:opacity-0 starting:scale-95';
@endphp

<div
    x-data="menu({ keepOpen: {{ $keepOpen ? 'true' : 'false' }} })"
    {{ $attributes->merge(['class' => $baseClasses]) }}
    tabindex="-1"
>
    {{ $slot }}
</div>
