@php
    $inputId = $attributes->get('id', 'autocomplete-' . uniqid());

    $variantClasses = match($variant) {
        'error' => 'border-destructive bg-destructive/5 focus-within:ring-destructive',
        'success' => 'border-success bg-success/5 focus-within:ring-success',
        default => 'border-border bg-input focus-within:ring-ring',
    };

    $baseClasses = 'relative shadow-xs inline-flex items-center w-full rounded-md border transition-all duration-fast focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2';

    $sizeClasses = match($size) {
        'xs' => 'px-2 text-xs',
        'sm' => 'px-2.5 text-sm',
        'lg' => 'px-4 text-lg',
        default => 'px-3 text-base',
    };

    $inputSizeClasses = match($size) {
        'xs' => 'py-1',
        'sm' => 'py-1.5',
        'lg' => 'py-2.5',
        default => 'py-2',
    };

    $iconSize = match($size) {
        'xs' => 'h-3 w-3',
        'sm' => 'h-3.5 w-3.5',
        'lg' => 'h-5 w-5',
        default => 'h-4 w-4',
    };

    $computedIconVariant = $iconVariant ?? 'outline';

    $inputAttributes = $attributes->except(['class', 'label', 'description', 'clearable', 'wire:model', 'wire:model.live', 'wire:model.blur', 'wire:model.defer'])->merge([
        'id' => $inputId,
    ]);

    $wrapperClasses = $attributes->get('class', '');
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-foreground mb-1.5">
            {{ $label }}
        </label>
    @endif

    @if($description)
        <p class="text-sm text-muted-foreground mb-2">
            {{ $description }}
        </p>
    @endif

    <div
        wire:ignore
        x-data="pegboardAutocomplete({
            clearable: {{ $clearable ? 'true' : 'false' }},
            value: @js($value),
            disabled: {{ $disabled ? 'true' : 'false' }}
        })"
        x-modelable="value"
        x-id="['{{ $inputId }}', '{{ $popoverId }}']"
        data-pegboard-group-item
        class="relative"
        {{ $attributes->only(['wire:model', 'wire:model.live', 'wire:model.blur', 'wire:model.defer']) }}
    >
        <div
            data-pegboard-control
            :class="open && 'ring-2 ring-ring'"
            class="{{ $baseClasses }} {{ $variantClasses }} {{ $sizeClasses }} {{ $wrapperClasses }} {{ $disabled ? 'opacity-60 cursor-not-allowed' : '' }}"
            style="anchor-name: {{ $popoverConfig['anchor'] }};"
        >
            @if($icon)
                <div class="flex items-center mr-2 text-muted-foreground">
                    <x-pegboard::icon :name="$icon" :variant="$computedIconVariant" :class="$iconSize"/>
                </div>
            @endif

            <input
                {{ $inputAttributes }}
                type="text"
                x-ref="input"
                @input="onInput"
                @focus="onFocus"
                @blur="onBlur"
                @keydown.down.prevent="navigateDown"
                @keydown.up.prevent="navigateUp"
                @keydown.enter.prevent="selectActive"
                @keydown.escape="close"
                autocomplete="off"
                role="combobox"
                :aria-expanded="open"
                :aria-controls="$id('{{ $popoverId }}')"
                :aria-activedescendant="activeIndex >= 0 ? 'autocomplete-option-' + activeIndex : null"
                {{ $disabled ? 'disabled' : '' }}
                class="flex-1 {{ $inputSizeClasses }} bg-transparent border-0 outline-none focus:outline-none focus:ring-0 text-foreground placeholder:text-sm placeholder:text-muted-foreground {{ $disabled ? 'cursor-not-allowed' : '' }}"
                @if($placeholder)
                    placeholder="{{ $placeholder }}"
                @endif
            >

            <div class="flex items-center gap-2 ml-2">
                @if($clearable)
                    <button
                        type="button"
                        @click="clear"
                        x-show="value && value.length > 0"
                        x-cloak
                        {{ $disabled ? 'disabled' : '' }}
                        class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast {{ $disabled ? 'opacity-60 cursor-not-allowed' : '' }}"
                        aria-label="Clear input"
                    >
                        <x-pegboard::icon name="x-mark" :variant="$computedIconVariant" :class="$iconSize"/>
                    </button>
                @endif
            </div>
        </div>

        <div
            x-ref="popover"
            x-show="open"
            id="{{ $popoverId }}"
            popover="manual"
            class="{{ $popoverConfig['base'] }} {{ $popoverConfig['transition'] }} {{ $popoverConfig['origin'] }} min-w-48 max-h-60 overflow-y-auto scrollbar-thin flex flex-col gap-1 rounded-lg shadow-lg border border-border bg-popover p-1.5"
            style="{{ $popoverConfig['styles'] }}"
            role="listbox"
        >
            {{ $slot }}

            @if(isset($empty))
                <div x-show="filteredItems.length === 0" x-cloak>
                    {{ $empty }}
                </div>
            @else
                <div
                    x-show="filteredItems.length === 0"
                    x-cloak
                    class="px-2 py-6 text-center text-sm text-muted-foreground"
                >
                    {{ $emptyText }}
                </div>
            @endif
        </div>
    </div>
</div>
