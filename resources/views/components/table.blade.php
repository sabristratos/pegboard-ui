@php
    // Base table classes
    $baseClasses = 'w-full text-left border-collapse relative';

    // Variant classes - striped uses Tailwind odd:bg-muted/30
    $variantClasses = match($variant) {
        'bordered' => 'border border-border',
        'striped' => '[&_tbody_tr:nth-child(odd)]:bg-muted/30',
        default => '',
    };

    // Hover effect - only on tbody rows
    $hoverClasses = '[&_tbody_tr]:hover:bg-primary/8 [&_tbody_tr]:transition-colors [&_tbody_tr]:duration-fast';

    // Sticky header classes - applied to thead via CSS selector
    // Note: bg-muted/50 is applied by thead component, bg-card ensures proper background when sticky
    $stickyHeaderClasses = $stickyHeader ? '[&_thead]:sticky [&_thead]:top-0 [&_thead]:z-20' : '';

    // Disable responsive wrapper when sticky header is enabled to prevent nested scroll containers
    $effectiveResponsive = $stickyHeader ? false : $responsive;

    // Wrapper classes for responsive - now container-aware with thin scrollbar
    $baseWrapper = '@container scrollbar-thin';
    $wrapperClasses = $effectiveResponsive ? $baseWrapper . ' overflow-x-auto' : $baseWrapper . ' @max-lg:overflow-x-auto';
@endphp

<div class="{{ $wrapperClasses }}">
    <table
        {{ $attributes->merge(['class' => trim($baseClasses . ' ' . $variantClasses . ' ' . $hoverClasses . ' ' . $stickyHeaderClasses)]) }}
    >
        {{ $slot }}
    </table>
</div>
