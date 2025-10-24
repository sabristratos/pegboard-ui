@php
    $isCard = $displayVariant === 'card';

    $variantClasses = match($variant) {
        'error' => $isCard ? 'border-destructive bg-destructive/5' : 'border-destructive',
        'success' => $isCard ? 'border-success bg-success/5' : 'border-success',
        default => 'border-border has-[:checked]:border-primary',
    };

    $indicatorSize = match($size) {
        'xs' => 'w-4 h-4',
        'sm' => 'w-4.5 h-4.5',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5',
    };

    $innerDotSize = match($size) {
        'xs' => 'w-1.5 h-1.5',
        'sm' => 'w-2 h-2',
        'lg' => 'w-2.5 h-2.5',
        default => 'w-2 h-2',
    };

    $labelSize = match($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'lg' => 'text-base',
        default => 'text-sm',
    };

    $spacing = match($size) {
        'xs' => 'gap-0.5',
        'sm' => 'gap-0.5',
        'lg' => 'gap-1',
        default => 'gap-0.5',
    };

    $padding = match($size) {
        'xs' => 'p-1.5 -m-1.5',
        'sm' => 'p-1.5 -m-1.5',
        'lg' => 'p-2.5 -m-2.5',
        default => 'p-2 -m-2',
    };

    $cardPadding = match($size) {
        'xs' => 'p-3',
        'sm' => 'p-3.5',
        'lg' => 'p-5',
        default => 'p-4',
    };

    $baseClasses = 'group relative inline-flex items-center cursor-pointer select-none transition-all duration-fast';
    $hoverClasses = $isCard ? 'hover:bg-muted/50' : '';
    $focusClasses = $isCard ? 'has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-ring has-[:focus-visible]:ring-offset-2' : '';
    $disabledClasses = 'has-[:disabled]:opacity-50 has-[:disabled]:cursor-not-allowed';

    $wrapperClasses = $isCard
        ? "bg-card {$hoverClasses} justify-between rounded-lg gap-4 {$cardPadding} border-2 {$variantClasses} w-full {$focusClasses} {$disabledClasses}"
        : "justify-start {$padding} rounded-md {$disabledClasses}";
@endphp

<label {{ $attributes->merge(['class' => $baseClasses . ' ' . $wrapperClasses]) }}>
    <input
        type="radio"
        x-bind:name="$data.groupName ?? @js($name)"
        value="{{ $value }}"
        @if($disabled) disabled @endif
        class="peer absolute opacity-0 w-0 h-0"
    />

    @if($isCard)
        <div class="flex-1">
            @if($label || $description || $slot->isNotEmpty())
                @if($slot->isNotEmpty())
                    {{ $slot }}
                @else
                    <div class="flex flex-col gap-1">
                        @if($label)
                            <span class="{{ $labelSize }} font-medium text-foreground">{{ $label }}</span>
                        @endif
                        @if($description)
                            <span class="{{ $labelSize }} text-muted-foreground">{{ $description }}</span>
                        @endif
                    </div>
                @endif
            @endif
        </div>

        <span class="relative inline-flex items-center justify-center shrink-0 {{ $indicatorSize }} rounded-full border-2 {{ $variantClasses }} transition-all duration-normal group-has-[:checked]:border-primary">
            <span class="{{ $innerDotSize }} rounded-full bg-primary scale-0 opacity-0 transition-transform-opacity duration-200 group-has-[:checked]:scale-100 group-has-[:checked]:opacity-100"></span>
        </span>
    @else
        <span class="relative inline-flex items-center justify-center shrink-0 {{ $indicatorSize }} rounded-full border-2 {{ $variantClasses }} transition-all duration-normal group-has-[:checked]:border-primary me-2">
            <span class="{{ $innerDotSize }} rounded-full bg-primary scale-0 opacity-0 transition-transform-opacity duration-200 group-has-[:checked]:scale-100 group-has-[:checked]:opacity-100"></span>
        </span>

        <div class="flex flex-col {{ $spacing }}">
            @if($label || $slot->isNotEmpty())
                @if($slot->isNotEmpty())
                    {{ $slot }}
                @else
                    <span class="{{ $labelSize }} text-foreground">{{ $label }}</span>
                    @if($description)
                        <span class="{{ $labelSize }} text-muted-foreground">{{ $description }}</span>
                    @endif
                @endif
            @endif
        </div>
    @endif
</label>
