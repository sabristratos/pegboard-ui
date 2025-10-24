@php
    $shadowClass = match($variant) {
        'elevated' => 'shadow-elevated',
        'outline' => 'shadow-card',
        default => 'shadow-card',
    };

    $paddingClass = match($padding) {
        'none' => 'p-0',
        'sm' => 'p-2 @xs:p-3',
        'lg' => 'p-4 @xs:p-5 @md:p-6',
        default => 'p-3 @xs:p-4',
    };
@endphp

<div
    {{ $attributes->class([
        '@container rounded-lg border border-border bg-card text-card-foreground transition-all duration-fast',
        $shadowClass,
        $paddingClass,
    ]) }}
    data-slot="card"
>
    @if($loading)
        <div class="flex items-center justify-center min-h-[120px] @md:min-h-[200px]">
            <x-pegboard::spinner variant="default" size="md" />
        </div>
    @else
        {{ $slot }}
    @endif
</div>
