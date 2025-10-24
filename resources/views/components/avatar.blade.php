@php
    $baseClasses = 'relative shrink-0 inline-flex items-center justify-center overflow-hidden select-none';

    $sizeClasses = match($size) {
        'xs' => 'h-6 w-6 text-xs',
        'sm' => 'h-8 w-8 text-xs',
        'lg' => 'h-12 w-12 text-base',
        '2xl' => 'h-16 w-16 text-lg',
        default => 'h-10 w-10 text-sm',
    };

    $radiusClasses = match($radius) {
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        default => 'rounded-full',
    };

    $colorClasses = match($color) {
        'primary' => 'bg-primary text-primary-foreground',
        'secondary' => 'bg-secondary text-secondary-foreground',
        'success' => 'bg-success text-success-foreground',
        'warning' => 'bg-warning text-warning-foreground',
        'danger' => 'bg-destructive text-destructive-foreground',
        default => 'bg-muted text-muted-foreground',
    };

    $ringClasses = '';
    if ($isBordered) {
        $ringClasses = match($color) {
            'primary' => 'ring-2 ring-primary ring-offset-2 ring-offset-background',
            'secondary' => 'ring-2 ring-secondary ring-offset-2 ring-offset-background',
            'success' => 'ring-2 ring-success ring-offset-2 ring-offset-background',
            'warning' => 'ring-2 ring-warning ring-offset-2 ring-offset-background',
            'danger' => 'ring-2 ring-destructive ring-offset-2 ring-offset-background',
            default => 'ring-2 ring-muted ring-offset-2 ring-offset-background',
        };
    }

    $initials = $getInitials();
@endphp

<div data-slot="avatar" {{ $attributes->merge(['class' => $baseClasses . ' ' . $sizeClasses . ' ' . $radiusClasses . ' ' . $colorClasses . ' ' . $ringClasses]) }}>
    @if($src)
        <img
            src="{{ $src }}"
            alt="{{ $name ?? '' }}"
            class="h-full w-full object-cover"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        >
        <span class="font-medium hidden">
            {{ $initials }}
        </span>
    @else
        <span class="font-medium">
            {{ $initials }}
        </span>
    @endif
</div>
