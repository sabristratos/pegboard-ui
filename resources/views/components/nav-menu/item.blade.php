@php
    $baseClasses = 'flex items-center gap-3 w-full px-3 py-2 text-sm rounded-md transition-colors duration-fast outline-none';
    $variantClasses = [
        'default' => 'text-foreground hover:bg-accent hover:text-accent-foreground',
        'destructive' => 'text-destructive hover:bg-destructive/10 hover:text-destructive',
    ];
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if($href)
        href="{{ $href }}"
    @else
        type="button"
    @endif
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses[$variant]]) }}
>
    @if($icon)
        <x-pegboard::icon :name="$icon" :variant="$iconVariant" class="h-4 w-4 shrink-0" />
    @endif

    <span class="flex-1 text-left">
        {{ $slot }}
    </span>
</{{ $tag }}>
