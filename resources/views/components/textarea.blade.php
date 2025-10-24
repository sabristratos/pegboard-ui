@php
    $baseClasses = 'w-full shadow-xs rounded-md border transition-all duration-fast focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed resize-y';

    $variantClasses = match($variant) {
        'error' => 'border-destructive bg-destructive/5 focus-visible:ring-destructive',
        'success' => 'border-success bg-success/5 focus-visible:ring-success',
        default => 'border-border bg-input focus-visible:ring-ring',
    };

    $sizeClasses = match($size) {
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-2.5 py-1.5 text-sm',
        'lg' => 'px-4 py-3 text-lg',
        default => 'px-3 py-2 text-base',
    };
@endphp

<div wire:ignore.self class="relative" data-pegboard-group-item x-data="pegboardTextarea({ copy: {{ $copy ? 'true' : 'false' }} })">
    <textarea
        x-ref="textarea"
        rows="{{ $rows }}"
        data-pegboard-control
        {{ $attributes->class([
            $baseClasses,
            $variantClasses,
            $sizeClasses,
            'text-foreground placeholder:text-muted-foreground',
            'opacity-disabled cursor-not-allowed' => $disabled,
        ]) }}
        @if($disabled) disabled @endif
    >{{ $slot }}</textarea>

    @if($clearable || $copy)
        <div class="absolute top-2 right-2 flex gap-2">
            @if($clearable)
                <button
                    type="button"
                    @click="clear"
                    x-show="$refs.textarea.value"
                    x-cloak
                    class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast"
                    aria-label="Clear"
                >
                    <x-pegboard::icon name="x-mark" variant="micro" class="h-4 w-4" />
                </button>
            @endif

            @if($copy)
                <button
                    type="button"
                    @click="copyToClipboard"
                    class="flex items-center transition-colors duration-fast"
                    :class="copied ? 'text-success' : 'text-muted-foreground hover:text-foreground'"
                    :aria-label="copied ? 'Copied!' : 'Copy to clipboard'"
                >
                    <x-pegboard::icon name="clipboard" variant="micro" class="h-4 w-4" x-show="!copied" />
                    <x-pegboard::icon name="check" variant="micro" class="h-4 w-4" x-show="copied" x-cloak />
                </button>
            @endif
        </div>
    @endif
</div>
