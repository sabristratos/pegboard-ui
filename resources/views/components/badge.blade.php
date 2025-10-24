@php
    $hasChildren = isset($children) && !empty(trim($children));
    $badgeContent = $hasChildren ? $content : $slot;

    $isIconOnly = ($icon || $iconRight) && empty(trim($badgeContent));

    $sizeClasses = '';
    if ($isDot) {
        $sizeClasses = 'h-2 w-2 rounded-full p-0';
    } else {
        $sizeClasses = match($size) {
            'sm' => $isIconOnly ? 'text-xs p-0.5 h-4 w-4' : 'text-xs px-1 py-0.5 min-w-4 h-4',
            'lg' => $isIconOnly ? 'text-sm p-0.5 h-6 w-6' : 'text-sm px-2 py-1 min-w-6 h-6',
            default => $isIconOnly ? 'text-xs p-0.5 h-5 w-5' : 'text-xs px-1.5 py-0.5 min-w-5 h-5',
        };
    }

    $shapeClasses = '';
    if (!$isDot) {
        $shapeClasses = match($shape) {
            'circle' => 'rounded-full aspect-square',
            default => $isIconOnly ? 'rounded-md aspect-square' : 'rounded-md',
        };
    }

    // Use complete static class strings for Tailwind JIT compiler
    $colorClasses = match("{$variant}-{$color}") {
        // Solid variants
        'solid-primary' => 'bg-primary text-primary-foreground',
        'solid-secondary' => 'bg-secondary text-secondary-foreground',
        'solid-success' => 'bg-success text-success-foreground',
        'solid-warning' => 'bg-warning text-warning-foreground',
        'solid-danger' => 'bg-destructive text-destructive-foreground',
        'solid-info' => 'bg-info text-info-foreground',
        'solid-default' => 'bg-muted text-muted-foreground',

        // Flat variants
        'flat-primary' => 'bg-primary/10 text-primary',
        'flat-secondary' => 'bg-accent/50 text-accent-foreground',
        'flat-success' => 'bg-success/10 text-success',
        'flat-warning' => 'bg-warning/10 text-warning',
        'flat-danger' => 'bg-destructive/10 text-destructive',
        'flat-info' => 'bg-info/10 text-info',
        'flat-default' => 'bg-muted/30 text-foreground',

        // Faded variants
        'faded-primary' => 'bg-primary/5 text-primary border-primary/20',
        'faded-secondary' => 'bg-secondary/5 text-secondary border-secondary/20',
        'faded-success' => 'bg-success/5 text-success border-success/20',
        'faded-warning' => 'bg-warning/5 text-warning border-warning/20',
        'faded-danger' => 'bg-destructive/5 text-destructive border-destructive/20',
        'faded-info' => 'bg-info/5 text-info border-info/20',
        'faded-default' => 'bg-muted/20 text-foreground border-border',

        // Shadow variants
        'shadow-primary' => 'bg-primary text-primary-foreground shadow-md',
        'shadow-secondary' => 'bg-secondary text-secondary-foreground shadow-md',
        'shadow-success' => 'bg-success text-success-foreground shadow-md',
        'shadow-warning' => 'bg-warning text-warning-foreground shadow-md',
        'shadow-danger' => 'bg-destructive text-destructive-foreground shadow-md',
        'shadow-info' => 'bg-info text-info-foreground shadow-md',
        'shadow-default' => 'bg-muted text-muted-foreground shadow-md',

        default => 'bg-muted text-muted-foreground',
    };

    $iconSize = match($size) {
        'sm' => 'h-3 w-3',
        'lg' => 'h-4 w-4',
        default => 'h-3.5 w-3.5',
    };
    $iconVariant = 'micro';

    $placementClasses = match($placement) {
        'top-left' => 'absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 z-10',
        'bottom-right' => 'absolute bottom-0 right-0 translate-x-1/2 translate-y-1/2 z-10',
        'bottom-left' => 'absolute bottom-0 left-0 -translate-x-1/2 translate-y-1/2 z-10',
        default => 'absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 z-10',
    };
@endphp

@if($hasChildren)
    <div {{ $attributes->merge(['class' => 'relative inline-block']) }}>
        {{ $children }}
        <span
            data-slot="badge"
            @class([
                'inline-flex items-center justify-center font-medium whitespace-nowrap transition-all duration-fast gap-1',
                $sizeClasses,
                $shapeClasses,
                $colorClasses,
                $placementClasses,
                'border' => $variant === 'faded',
                'ring-2' => $showOutline && !$isDot,
                'ring-background' => $showOutline && !$isDot,
                'invisible' => $isInvisible,
                'opacity-0' => $isInvisible,
            ])
        >
            @if(!$isDot)
                @if($icon)
                    <x-pegboard::icon :name="$icon" :variant="$iconVariant" :class="$iconSize"/>
                @endif

                @if($badgeContent)
                    <span>{{ $badgeContent }}</span>
                @endif

                @if($iconRight)
                    <x-pegboard::icon :name="$iconRight" :variant="$iconVariant" :class="$iconSize"/>
                @endif
            @endif
        </span>
    </div>
@else
    <span
        data-slot="badge"
        {{ $attributes->class([
            'inline-flex items-center justify-center font-medium whitespace-nowrap transition-all duration-fast gap-1',
            $sizeClasses,
            $shapeClasses,
            $colorClasses,
            'border' => $variant === 'faded',
            'ring-2' => $showOutline && !$isDot,
            'ring-none' => $showOutline && !$isDot,
            'invisible' => $isInvisible,
            'opacity-0' => $isInvisible,
        ]) }}
    >
        @if(!$isDot)
            @if($icon)
                <x-pegboard::icon :name="$icon" :variant="$iconVariant" :class="$iconSize"/>
            @endif

            {{ $badgeContent }}

            @if($iconRight)
                <x-pegboard::icon :name="$iconRight" :variant="$iconVariant" :class="$iconSize"/>
            @endif
        @endif
    </span>
@endif
