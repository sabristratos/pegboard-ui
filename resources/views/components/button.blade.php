@php
    $slotHtml = $slot->toHtml();
    $withoutSrOnly = preg_replace('/<[^>]*class="[^"]*(?:sr-only|visually-hidden)[^"]*"[^>]*>.*?<\/[^>]+>/s', '', $slotHtml);
    $hasVisibleContent = !empty(trim(strip_tags($withoutSrOnly)));
    $isIconOnly = $iconOnly || (($icon || $iconRight) && !$hasVisibleContent);

    $isSolidVariant = in_array($variant, ['primary', 'secondary', 'destructive', 'success']);

    $baseClasses = 'relative inline-flex items-center justify-center rounded-md font-medium cursor-pointer transition-all duration-fast focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 [[data-slot=button-group]_&]:rounded-none [[data-slot=button-group]_&:first-child]:rounded-s-md [[data-slot=button-group]_&:last-child]:rounded-e-md [[data-slot=button-group]_&:not(:first-child)]:border-s [[data-slot=button-group]_&:not(:first-child)]:border-s-border/30';

    $realisticClasses = $isSolidVariant
        ? 'overflow-hidden before:absolute before:inset-0 before:bg-gradient-to-b before:from-white/20 before:to-transparent before:pointer-events-none shadow-[var(--inset-shadow-button)] active:shadow-[var(--inset-shadow-button-active)]'
        : '';

    $sizeClasses = match($size) {
        'xs' => $isIconOnly ? 'p-0.5 text-xs aspect-square' : 'py-0.5 px-2 gap-1.5 text-xs @max-xs:px-1.5',
        'sm' => $isIconOnly ? 'p-1 text-sm aspect-square' : 'py-1 px-3 gap-2 text-sm @max-xs:px-2 @max-xs:gap-1.5',
        'lg' => $isIconOnly ? 'p-2.5 text-lg aspect-square' : 'py-2.5 px-6 gap-3 text-lg @max-xs:px-4 @max-xs:gap-2',
        default => $isIconOnly ? 'p-1.5 text-base aspect-square' : 'py-1.5 px-4 gap-2 text-base @max-xs:px-3 @max-xs:gap-1.5',
    };

    $iconSize = match($size) {
        'xs' => 'h-3 w-3',
        'sm' => 'h-3.5 w-3.5',
        'lg' => 'h-5 w-5',
        default => 'h-4 w-4',
    };

    $computedIconVariant = $iconVariant ?? match($size) {
        'xs' => 'micro',
        default => 'mini',
    };

    $variantClasses = match($variant) {
        'secondary' => 'bg-secondary text-secondary-foreground border border-secondary/60 shadow-md shadow-secondary/30 hover:bg-secondary/90 active:bg-secondary/80 active:shadow-none active:scale-[0.98] focus-visible:ring-secondary',
        'destructive' => 'bg-destructive text-destructive-foreground border border-destructive/60 shadow-md shadow-destructive/30 hover:bg-destructive/90 active:bg-destructive/80 active:shadow-none active:scale-[0.98] focus-visible:ring-destructive',
        'success' => 'bg-success text-success-foreground border border-success/60 shadow-md shadow-success/30 hover:bg-success/90 active:bg-success/80 active:shadow-none active:scale-[0.98] focus-visible:ring-success',
        'outline' => 'border border-border bg-background text-foreground hover:bg-muted hover:shadow-xs active:bg-muted/50 active:shadow-none active:scale-[0.98] focus-visible:ring-primary',
        'ghost' => 'text-foreground hover:bg-muted active:bg-muted/80 active:scale-[0.98] focus-visible:ring-primary',
        default => 'bg-primary text-primary-foreground border border-primary/60 shadow-md shadow-primary/30 hover:bg-primary/90 active:bg-primary/80 active:shadow-none active:scale-[0.98] focus-visible:ring-primary',
    };

@endphp

<button
    data-slot="button"
    {{ $attributes->class([
        $baseClasses,
        $realisticClasses,
        $sizeClasses,
        $variantClasses,
        'opacity-disabled cursor-not-allowed' => $loading || $disabled,
    ])->merge(['type' => 'button']) }}
    @if($loading || $disabled) disabled @endif
    @if($loading) aria-busy="true" @endif
>
    @if($loading)
        <x-pegboard::spinner :class="$iconSize" />
        @unless($isIconOnly)
            <span>{{ $loadingText ?? 'Loading...' }}</span>
        @endunless
    @else
        @if($icon)
            <x-pegboard::icon :name="$icon" :variant="$computedIconVariant" :class="$iconSize"/>
        @endif

        {{ $slot }}

        @if($iconRight)
            <x-pegboard::icon :name="$iconRight" :variant="$computedIconVariant" :class="$iconSize"/>
        @endif
    @endif
</button>
