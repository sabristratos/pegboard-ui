@php
    // Alignment classes
    $alignClasses = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };

    // Base classes
    $baseClasses = 'text-foreground';

    // Size-based padding and text size - now container-responsive
    $sizeClasses = match($size) {
        'xs' => 'px-1.5 @xs:px-2 py-2 text-xs',
        'sm' => 'px-2 @xs:px-3 py-2.5 text-sm',
        'lg' => 'px-4 @xs:px-5 @md:px-6 py-4 text-base',
        default => 'px-2 @xs:px-3 @md:px-4 py-3 text-sm',
    };

    // Sticky positioning classes
    if ($sticky === 'left' || $sticky === true) {
        $baseClasses .= ' sticky left-0 z-10 bg-card';
    } elseif ($sticky === 'right') {
        $baseClasses .= ' sticky right-0 z-10 bg-card';
    }
@endphp

<td {{ $attributes->merge(['class' => trim($alignClasses . ' ' . $baseClasses . ' ' . $sizeClasses)]) }}>
    {{ $slot }}
</td>
