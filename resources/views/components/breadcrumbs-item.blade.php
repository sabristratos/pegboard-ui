<li class="flex items-center gap-2 @max-xs:gap-1 group">
    @if($href)
        <a href="{{ $href }}" class="flex items-center gap-1.5 @max-xs:gap-1 text-muted-foreground hover:text-foreground transition-colors truncate">
            @if($icon)
                <x-pegboard::icon :name="$icon" :variant="$iconVariant" class="h-4 w-4 @max-xs:h-3 @max-xs:w-3 shrink-0" />
            @endif
            @if($slot->isNotEmpty())
                <span class="truncate">{{ $slot }}</span>
            @endif
        </a>
    @else
        <span class="flex items-center gap-1.5 @max-xs:gap-1 text-foreground font-medium truncate" aria-current="page">
            @if($icon)
                <x-pegboard::icon :name="$icon" :variant="$iconVariant" class="h-4 w-4 @max-xs:h-3 @max-xs:w-3 shrink-0" />
            @endif
            @if($slot->isNotEmpty())
                <span class="truncate">{{ $slot }}</span>
            @endif
        </span>
    @endif

    <span class="text-muted-foreground group-last:hidden shrink-0">
        @if($separator === 'slash')
            <span class="text-sm @max-xs:text-xs">/</span>
        @else
            <x-pegboard::icon :name="$separator" variant="mini" class="h-4 w-4 @max-xs:h-3 @max-xs:w-3" />
        @endif
    </span>
</li>
