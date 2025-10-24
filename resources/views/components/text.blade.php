@php
    $colorClasses = match($variant) {
        'strong' => 'text-foreground font-medium',
        'subtle' => 'text-muted-foreground',
        default => 'text-foreground',
    };
@endphp

<span {{ $attributes->merge(['class' => $colorClasses]) }}>
    {{ $slot }}
</span>
