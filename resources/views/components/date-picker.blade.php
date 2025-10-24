@php
$format = (string) $format;
$range = (bool) $range;
$placeholder = $placeholder ?: ($range ? 'Select date range' : 'Select date');

$variantClasses = match($variant) {
    'error' => 'border-destructive bg-destructive/5 focus:ring-destructive',
    'success' => 'border-success bg-success/5 focus:ring-success',
    default => 'border-border bg-input focus:ring-ring',
};

$sizeClasses = match($size) {
    'xs' => 'px-2 py-1 text-xs pr-8',
    'sm' => 'px-2.5 py-1.5 text-sm pr-9',
    'lg' => 'px-4 py-2.5 text-lg pr-11',
    default => 'px-3 py-2 text-base pr-10',
};

$iconSize = match($size) {
    'xs' => 'w-3.5 h-3.5',
    'sm' => 'w-4 h-4',
    'lg' => 'w-6 h-6',
    default => 'w-5 h-5',
};

$iconPosition = match($size) {
    'xs' => 'right-1.5',
    'sm' => 'right-2',
    'lg' => 'right-3',
    default => 'right-2',
};

$inputAttributes = $attributes->except(['class']);
$wrapperClasses = $attributes->get('class', '');
@endphp

<div
    x-data="pegboardDatePicker({ format: '{{ $format }}', range: {{ $range ? 'true' : 'false' }}, value: @js($value) })"
    {{ $attributes->only('class')->merge(['class' => 'relative ' . $wrapperClasses]) }}
>
    <div class="relative" style="anchor-name: {{ $popoverConfig['anchor'] }};">
        <input
            {{ $inputAttributes }}
            x-ref="input"
            type="text"
            placeholder="{{ $placeholder }}"
            x-mask:dynamic="getMask()"
            @input="onInput"
            @blur="onBlur"
            @keydown.enter.prevent="confirmDate"
            @keydown.escape="closePopover"
            data-pegboard-control
            {{ $disabled ? 'disabled' : '' }}
            class="w-full rounded-lg border {{ $variantClasses }} {{ $sizeClasses }} transition-colors duration-fast placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:border-transparent {{ $disabled ? 'opacity-disabled cursor-not-allowed' : '' }}"
        />

        <div class="absolute {{ $iconPosition }} top-1/2 -translate-y-1/2 flex items-center gap-2">
            @if($clearable)
                <button
                    type="button"
                    @click="clear"
                    x-show="$refs.input.value"
                    x-cloak
                    {{ $disabled ? 'disabled' : '' }}
                    class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast {{ $disabled ? 'opacity-disabled cursor-not-allowed' : '' }}"
                    aria-label="Clear"
                >
                    <x-pegboard::icon name="x-mark" variant="micro" :class="$iconSize" />
                </button>
            @endif

            <button
                type="button"
                @click="togglePopover"
                tabindex="-1"
                {{ $disabled ? 'disabled' : '' }}
                class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast {{ $disabled ? 'opacity-disabled cursor-not-allowed' : '' }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="{{ $iconSize }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </button>
        </div>
    </div>

    <div
        x-ref="popover"
        x-show="isOpen"
        @click.outside="closePopover"
        @keydown.escape.window="closePopover"
        id="{{ $popoverId }}"
        popover="manual"
        class="{{ $popoverConfig['base'] }} {{ $popoverConfig['transition'] }} {{ $popoverConfig['origin'] }} bg-popover border border-border rounded-lg shadow-lg p-0 m-0"
        style="{{ $popoverConfig['styles'] }}"
    >
        <div class="p-3 min-w-[280px]">
            @include('pegboard::components.date-picker.calendar')
        </div>
    </div>
</div>
