@php
    // Alignment classes
    $alignClasses = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };

    // Base classes
    $baseClasses = 'font-semibold text-muted-foreground';

    // Size-based padding and text size - now container-responsive
    $sizeClasses = match($size) {
        'xs' => 'px-1.5 @xs:px-2 py-2 text-xs',
        'sm' => 'px-2 @xs:px-3 py-2.5 text-sm',
        'lg' => 'px-4 @xs:px-5 @md:px-6 py-4 text-base',
        default => 'px-2 @xs:px-3 @md:px-4 py-3 text-sm',
    };

    // Add sortable cursor
    if ($sortable) {
        $baseClasses .= ' cursor-pointer hover:text-foreground';
    }

    // Apply sticky column classes
    if ($sticky === 'left' || $sticky === true) {
        $baseClasses .= ' sticky left-0 z-30 bg-card';
    } elseif ($sticky === 'right') {
        $baseClasses .= ' sticky right-0 z-30 bg-card';
    }
@endphp

<th {{ $attributes->merge(['class' => trim($alignClasses . ' ' . $baseClasses . ' ' . $sizeClasses)]) }}>
    {{ $slot }}
</th>
