@php
    $layoutClasses = $inline
        ? 'flex items-center gap-4'
        : 'flex flex-col items-center gap-3 py-8';

    $baseClasses = "
        relative
        border-2 border-dashed border-border
        rounded-lg
        bg-input hover:bg-muted/50
        transition-all duration-fast
        cursor-pointer
        px-6
        {$layoutClasses}
    ";
@endphp

<div
    data-pegboard-file-dropzone
    {{ $attributes->merge(['class' => $baseClasses]) }}
    :class="{
        'border-primary bg-primary/5 scale-[1.02]': isDragging && !isInvalidType,
        'border-warning bg-warning/5 cursor-not-allowed': isInvalidType,
        'pointer-events-none opacity-disabled animate-pulse': isLoading,
        'border-destructive bg-destructive/5': hasError
    }"
>
    @if(!$inline || !$withProgress)
        <div class="flex-shrink-0">
            <x-pegboard::icon
                :name="$icon"
                variant="outline"
                class="text-muted-foreground"
                :class="$inline ? 'h-8 w-8' : 'h-12 w-12'"
            />
        </div>
    @endif

    <div class="{{ $inline ? 'flex-1 min-w-0' : 'text-center' }}">
        @if($heading)
            <p class="text-sm font-medium text-foreground {{ $inline ? 'truncate' : '' }}">
                {{ $heading }}
            </p>
        @endif

        @if($text)
            <p class="text-xs text-muted-foreground {{ $inline ? 'truncate' : 'mt-1' }}">
                {{ $text }}
            </p>
        @endif

        @if($withProgress)
            <div class="mt-2 w-full">
                <div class="h-1.5 w-full bg-muted rounded-full overflow-hidden">
                    <div
                        x-show="isLoading"
                        class="h-full bg-primary transition-all duration-normal ease-in-out"
                        x-bind:style="`width: ${progress}%`"
                    ></div>
                </div>
                <p x-show="isLoading" class="text-xs text-muted-foreground mt-1 text-center transition-opacity duration-fast" x-text="`${progress}%`"></p>
            </div>
        @endif
    </div>

    @if($inline && !$withProgress)
        <div class="flex-shrink-0">
            <svg class="animate-spin h-5 w-5 text-primary" x-show="isLoading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    @endif
</div>
