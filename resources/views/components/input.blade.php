@php
    $wireModelAttr = collect($attributes->getAttributes())->keys()->first(fn($key) => str_starts_with($key, 'wire:model'));
    $wireModelValue = $wireModelAttr ? $attributes->get($wireModelAttr) : null;
    $inputId = $attributes->get('id', $wireModelValue ? 'input-' . str_replace('.', '-', $wireModelValue) : 'input-' . uniqid());

    $baseClasses = 'relative shadow-xs inline-flex items-center w-full rounded-md border transition-all duration-fast focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2';

    $variantClasses = match($variant) {
        'error' => 'border-destructive bg-destructive/5 focus-within:ring-destructive',
        'success' => 'border-success bg-success/5 focus-within:ring-success',
        default => 'border-border bg-input focus-within:ring-ring',
    };

    $sizeClasses = match($size) {
        'xs' => 'pl-1.5 pr-1 text-xs',
        'sm' => 'pl-2 pr-1 text-sm',
        'lg' => 'pl-4 pr-2 text-lg',
        default => 'pl-3 pr-1.5 text-base',
    };

    $inputSizeClasses = match($size) {
        'xs' => 'py-0.5 leading-tight',
        'sm' => 'py-1 leading-normal',
        'lg' => 'py-2.5 leading-normal',
        default => 'py-1.5 leading-normal',
    };

    $iconSize = match($size) {
        'xs' => 'h-3 w-3',
        'sm' => 'h-3.5 w-3.5',
        'lg' => 'h-5 w-5',
        default => 'h-4 w-4',
    };

    $computedIconVariant = $iconVariant ?? match($size) {
        'xs' => 'micro',
        default => 'mini',
    };

    $inputAttributes = $attributes->except(['class', 'clearable', 'showPassword', 'copy', 'viewInNewPage']);
@endphp

<div
    x-data="pegboardInput({
        clearable: {{ $clearable ? 'true' : 'false' }},
        showPassword: {{ $showPassword ? 'true' : 'false' }},
        copy: {{ $copy ? 'true' : 'false' }},
        viewInNewPage: {{ $viewInNewPage ? 'true' : 'false' }}
    })"
    data-pegboard-group-item
    data-pegboard-control
    {{ $attributes->only('class')->class([
        $baseClasses,
        $variantClasses,
        $sizeClasses,
        'opacity-disabled cursor-not-allowed' => $disabled,
    ]) }}
>
    @if($icon)
        <div class="flex items-center mr-2 text-muted-foreground">
            <x-pegboard::icon :name="$icon" :variant="$computedIconVariant" :class="$iconSize"/>
        </div>
    @endif

    @if(isset($prefix))
        <div class="flex items-center text-muted-foreground select-none mr-1">
            {{ $prefix }}
        </div>
    @endif

    <input
        {{ $inputAttributes }}
        id="{{ $inputId }}"
        :type="inputType"
        wire:key="{{ $inputId }}"
        class="flex-1 min-w-0 {{ $inputSizeClasses }} bg-transparent border-0 outline-none focus:outline-none focus:ring-0 text-foreground placeholder:text-muted-foreground disabled:cursor-not-allowed [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
        x-ref="input"
        @if($disabled) disabled @endif
    >

    @if(isset($suffix))
        <div class="flex items-center text-muted-foreground select-none ml-1">
            {{ $suffix }}
        </div>
    @endif

    <div class="flex items-center gap-2 ml-2 shrink-0">
        {{ $actions ?? '' }}

        @if($iconRight)
            <div class="flex items-center text-muted-foreground">
                <x-pegboard::icon :name="$iconRight" :variant="$computedIconVariant" :class="$iconSize"/>
            </div>
        @endif

        @if($clearable)
            <button
                type="button"
                @click="clear"
                x-show="inputValue"
                x-cloak
                class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast"
                aria-label="Clear input"
            >
                <x-pegboard::icon name="x-mark" :variant="$computedIconVariant" :class="$iconSize"/>
            </button>
        @endif

        @if($showPassword)
            <button
                type="button"
                @click="togglePasswordVisibility"
                class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast"
                aria-label="Toggle password visibility"
            >
                <x-pegboard::icon name="eye" :variant="$computedIconVariant" :class="$iconSize" x-show="!passwordVisible"/>
                <x-pegboard::icon name="eye-slash" :variant="$computedIconVariant" :class="$iconSize" x-show="passwordVisible" x-cloak/>
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
                <x-pegboard::icon name="clipboard" :variant="$computedIconVariant" :class="$iconSize" x-show="!copied"/>
                <x-pegboard::icon name="check" :variant="$computedIconVariant" :class="$iconSize" x-show="copied" x-cloak/>
            </button>
        @endif

        @if($viewInNewPage)
            <a
                :href="$refs.input?.value"
                target="_blank"
                rel="noopener noreferrer"
                x-show="$refs.input?.value && isValidUrl()"
                x-cloak
                class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast"
                aria-label="Open in new tab"
            >
                <x-pegboard::icon name="arrow-top-right-on-square" :variant="$computedIconVariant" :class="$iconSize"/>
            </a>
        @endif
    </div>
</div>
