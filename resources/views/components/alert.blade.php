@php
    $displayIcon = $icon ?? $getDefaultIcon();

    $borderClass = match($variant) {
        'success' => 'border-success',
        'warning' => 'border-warning',
        'danger' => 'border-destructive',
        'info' => 'border-info',
        default => 'border-border',
    };

    [$iconBgClass, $iconTextClass] = match($variant) {
        'success' => ['bg-success', 'text-white'],
        'warning' => ['bg-warning', 'text-white'],
        'danger' => ['bg-destructive', 'text-white'],
        'info' => ['bg-info', 'text-white'],
        default => ['bg-muted', 'text-foreground'],
    };
@endphp

<div
    {{ $attributes->class([
        '@container flex @max-xs:flex-col gap-2.5 @max-xs:gap-1.5 rounded-lg border bg-card p-3 shadow-sm transition-all duration-fast',
        $borderClass,
    ]) }}
    data-slot="alert"
>
    @if($showIcon)
        <div @class([
            'flex shrink-0 items-center justify-center size-8 rounded-full @max-xs:self-start',
            $iconBgClass,
            $iconTextClass,
        ])>
            <x-pegboard::icon :name="$displayIcon" variant="micro" class="h-4 w-4" />
        </div>
    @endif

    <div class="flex-1 space-y-0.5 {{ $title ? '' : 'flex items-center @max-xs:block' }}">
        @if($title)
            <x-pegboard::heading level="3" class="text-sm">{{ $title }}</x-pegboard::heading>
        @endif

        <x-pegboard::text class="text-sm">
            {{ $slot }}
        </x-pegboard::text>
    </div>
</div>
