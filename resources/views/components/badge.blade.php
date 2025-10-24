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

    $colorMap = [
        'primary' => ['base' => 'primary', 'fg' => 'primary-foreground'],
        'secondary' => ['base' => 'secondary', 'fg' => 'secondary-foreground'],
        'success' => ['base' => 'success', 'fg' => 'success-foreground'],
        'warning' => ['base' => 'warning', 'fg' => 'warning-foreground'],
        'danger' => ['base' => 'destructive', 'fg' => 'destructive-foreground'],
        'default' => ['base' => 'muted', 'fg' => 'muted-foreground'],
    ];

    $c = $colorMap[$color] ?? $colorMap['default'];

    [$bgClass, $textClass] = match($variant) {
        'solid' => ["bg-{$c['base']}", "text-{$c['fg']}"],
        'flat' => $color === 'default'
            ? ['bg-muted/30', 'text-foreground']
            : ["bg-{$c['base']}/10", "text-{$c['base']}"],
        'faded' => $color === 'default'
            ? ['bg-muted/20', 'text-foreground']
            : ["bg-{$c['base']}/5", "text-{$c['base']}"],
        'shadow' => ["bg-{$c['base']}", "text-{$c['fg']}"],
        default => ['bg-muted', 'text-muted-foreground'],
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
                $bgClass,
                $textClass,
                $placementClasses,
                'border' => $variant === 'faded',
                "border-{$c['base']}/20" => $variant === 'faded',
                'shadow-md' => $variant === 'shadow',
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
            $bgClass,
            $textClass,
            'border' => $variant === 'faded',
            "border-{$c['base']}/20" => $variant === 'faded',
            'shadow-md' => $variant === 'shadow',
            'ring-2' => $showOutline && !$isDot,
            'ring-background' => $showOutline && !$isDot,
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
