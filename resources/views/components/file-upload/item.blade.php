@php
    $baseClasses = "
        flex items-center gap-3
        p-3 rounded-lg
        border border-border
        bg-card
        transition-colors duration-fast
    ";

    $stateClasses = $invalid
        ? 'border-destructive bg-destructive/5'
        : 'hover:bg-muted/50';
@endphp

<div data-pegboard-file-item {{ $attributes->merge(['class' => $baseClasses . ' ' . $stateClasses]) }}>
    <div class="flex-shrink-0">
        @if($image)
            <img
                src="{{ $image }}"
                alt="{{ $heading }}"
                class="h-10 w-10 rounded object-cover"
            />
        @else
            <div class="h-10 w-10 rounded bg-muted flex items-center justify-center">
                <x-pegboard::icon
                    :name="$icon"
                    variant="outline"
                    class="h-5 w-5 text-muted-foreground"
                />
            </div>
        @endif
    </div>

    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-foreground truncate">
            {{ $heading }}
        </p>
        <p class="text-xs text-muted-foreground">
            {{ $text ?? $formattedSize }}
        </p>
    </div>

    @isset($actions)
        <div class="flex-shrink-0 flex items-center gap-1">
            {{ $actions }}
        </div>
    @endisset
</div>
