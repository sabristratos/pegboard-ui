@php
    $sizeClass = match($size) {
        'sm' => 'h-2 w-2',
        'lg' => 'h-4 w-4',
        default => 'h-3 w-3',
    };

    $bgClass = match($variant) {
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-destructive',
        'info' => 'bg-info',
        default => 'bg-muted-foreground',
    };
@endphp

<div
    {{ $attributes->class(['inline-flex items-center gap-2']) }}
    data-slot="status"
>
    <span class="relative inline-flex">
        <span @class([
            'inline-block rounded-full',
            $sizeClass,
            $bgClass,
        ])></span>

        @if($pulse)
            <span @class([
                'absolute inline-flex h-full w-full rounded-full opacity-75 animate-ping',
                $bgClass,
            ])></span>
        @endif
    </span>

    @if($label || $slot->isNotEmpty())
        <span class="text-sm text-foreground">
            {{ $label ?? $slot }}
        </span>
    @endif
</div>
