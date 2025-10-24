@php
$format = (string) $format;
$step = (int) $step;
$disabled = (bool) $disabled;
$placeholder = $placeholder ?: ($format === '24' ? 'HH:mm' : 'hh:mm AM');

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
    x-data="pegboardTimePicker({ format: '{{ $format }}', step: {{ $step }}, disabled: {{ $disabled ? 'true' : 'false' }} })"
    {{ $attributes->only('class')->merge(['class' => 'relative ' . $wrapperClasses]) }}
>
    <div class="relative" style="anchor-name: {{ $popoverConfig['anchor'] }};">
        <input
            {{ $inputAttributes }}
            x-ref="input"
            type="text"
            placeholder="{{ $placeholder }}"
            x-mask:dynamic="format === '24' ? '99:99' : false"
            @input="onInput"
            @blur="onBlur"
            @keydown.enter.prevent="selectCurrentTime"
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
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
            <!-- Current time display -->
            <div class="text-center mb-3 pb-3 bg-accent/10 -mx-3 -mt-3 px-3 pt-3 rounded-t-lg border-b border-border">
                <div class="text-lg font-semibold text-foreground" x-text="displayTime"></div>
            </div>

            <div class="flex gap-2">
                <!-- Hours -->
                <div class="flex-1 border-r border-border pr-2">
                    <div class="text-xs font-medium text-muted-foreground mb-2 text-center">Hour</div>
                    <div class="max-h-[180px] overflow-y-auto overscroll-contain scrollbar-thin scrollbar-thumb-border scrollbar-track-transparent bg-muted/30 rounded p-1">
                        <div class="space-y-1">
                            <template x-for="hour in hours" :key="hour">
                                <button
                                    type="button"
                                    @click="selectHour(hour)"
                                    :class="{
                                        'bg-primary text-primary-foreground': hour === selectedHour,
                                        'text-foreground hover:bg-accent hover:text-accent-foreground': hour !== selectedHour
                                    }"
                                    class="w-full px-3 py-1.5 text-sm rounded transition-colors duration-fast text-center"
                                    x-text="formatHour(hour)"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Minutes -->
                <div class="flex-1 border-r border-border pr-2">
                    <div class="text-xs font-medium text-muted-foreground mb-2 text-center">Min</div>
                    <div class="max-h-[180px] overflow-y-auto overscroll-contain scrollbar-thin scrollbar-thumb-border scrollbar-track-transparent bg-muted/30 rounded p-1">
                        <div class="space-y-1">
                            <template x-for="minute in minutes" :key="minute">
                                <button
                                    type="button"
                                    @click="selectMinute(minute)"
                                    :class="{
                                        'bg-primary text-primary-foreground': minute === selectedMinute,
                                        'text-foreground hover:bg-accent hover:text-accent-foreground': minute !== selectedMinute
                                    }"
                                    class="w-full px-3 py-1.5 text-sm rounded transition-colors duration-fast text-center"
                                    x-text="formatMinute(minute)"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Period (AM/PM) for 12-hour format -->
                <div x-show="format === '12'" class="flex-1 pl-2">
                    <div class="text-xs font-medium text-muted-foreground mb-2 text-center">Period</div>
                    <div class="space-y-1 bg-muted/30 rounded p-1">
                        <button
                            type="button"
                            @click="selectPeriod('AM')"
                            :class="{
                                'bg-primary text-primary-foreground': period === 'AM',
                                'text-foreground hover:bg-accent hover:text-accent-foreground': period !== 'AM'
                            }"
                            class="w-full px-3 py-1.5 text-sm rounded transition-colors duration-fast"
                        >AM</button>
                        <button
                            type="button"
                            @click="selectPeriod('PM')"
                            :class="{
                                'bg-primary text-primary-foreground': period === 'PM',
                                'text-foreground hover:bg-accent hover:text-accent-foreground': period !== 'PM'
                            }"
                            class="w-full px-3 py-1.5 text-sm rounded transition-colors duration-fast"
                        >PM</button>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2 mt-3 pt-3 border-t border-border">
                <button
                    type="button"
                    @click="setNow"
                    class="flex-1 px-3 py-1.5 text-sm rounded border border-border text-foreground hover:bg-accent hover:text-accent-foreground hover:border-accent transition-colors duration-fast"
                >Now</button>
                <button
                    type="button"
                    @click="clearTime"
                    class="flex-1 px-3 py-1.5 text-sm rounded border border-border text-foreground hover:bg-accent hover:text-accent-foreground hover:border-accent transition-colors duration-fast"
                >Clear</button>
            </div>
        </div>
    </div>
</div>
