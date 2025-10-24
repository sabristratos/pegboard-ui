@php
    $variantClasses = match($variant) {
        'muted' => 'text-muted-foreground hover:text-foreground',
        'primary' => 'text-primary hover:text-primary/80',
        default => 'text-foreground hover:text-primary',
    };

    $underlineClasses = match($underline) {
        'none' => 'no-underline',
        'always' => 'underline',
        default => 'no-underline hover:underline',
    };

    $sizeClasses = match($size) {
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        default => 'text-base',
    };

    $baseClasses = 'inline-flex items-center gap-1 transition-colors duration-fast focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary';
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => "$baseClasses $variantClasses $underlineClasses $sizeClasses"]) }}
    @if($external)
        target="_blank"
        rel="noopener noreferrer"
    @endif
>
    {{ $slot }}
    @if($external)
        <x-pegboard::icon name="arrow-top-right-on-square" variant="mini" class="h-3.5 w-3.5" />
    @endif
</a>
