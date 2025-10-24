@php
    $sizeClasses = match($size) {
        'xl' => 'text-2xl font-semibold tracking-tight',
        'lg' => 'text-xl font-semibold tracking-tight',
        'sm' => 'text-base font-semibold',
        default => 'text-lg font-semibold',
    };

    $element = $level ? "h{$level}" : 'div';
@endphp

<{{ $element }} {{ $attributes->merge(['class' => "$sizeClasses text-foreground"]) }}>
    {{ $slot }}
</{{ $element }}>
