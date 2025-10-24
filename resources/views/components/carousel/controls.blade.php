<button
    x-on:click="prev()"
    :disabled="!canGoPrev"
    :class="{ 'opacity-50 cursor-not-allowed': !canGoPrev }"
    class="absolute left-4 top-1/2 -translate-y-1/2 z-10 inline-flex items-center justify-center h-10 w-10 rounded-full bg-popover text-popover-foreground border border-border shadow-elevated transition-all duration-fast hover:bg-muted focus-visible:outline-2 focus-visible:outline-ring disabled:pointer-events-none"
    aria-label="Previous slide"
>
    <x-pegboard::icon name="chevron-left" variant="mini" class="h-5 w-5" />
</button>

<button
    x-on:click="next()"
    :disabled="!canGoNext"
    :class="{ 'opacity-50 cursor-not-allowed': !canGoNext }"
    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 inline-flex items-center justify-center h-10 w-10 rounded-full bg-popover text-popover-foreground border border-border shadow-elevated transition-all duration-fast hover:bg-muted focus-visible:outline-2 focus-visible:outline-ring disabled:pointer-events-none"
    aria-label="Next slide"
>
    <x-pegboard::icon name="chevron-right" variant="mini" class="h-5 w-5" />
</button>
