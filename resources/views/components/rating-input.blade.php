@props(['max' => 5, 'size' => 'md', 'icon' => 'star', 'variant' => 'warning', 'disabled' => false, 'showReset' => true, 'showValue' => true])

@php
$max = (int) $max;
$disabled = (bool) $disabled;
$showReset = (bool) $showReset;
$showValue = (bool) $showValue;

$sizeClasses = match($size) {
    'sm' => 'w-4 h-4',
    'lg' => 'w-8 h-8',
    default => 'w-6 h-6',
};

$variantClasses = match($variant) {
    'primary' => 'text-primary',
    'destructive' => 'text-destructive',
    'success' => 'text-success',
    'pink' => 'text-pink-600',
    default => 'text-warning',
};

$inputAttributes = $attributes->except(['class']);
$wrapperClasses = $attributes->get('class', '');
@endphp

<div
    x-data="pegboardRating({ maxStars: {{ $max }}, disabled: {{ $disabled ? 'true' : 'false' }} })"
    {{ $attributes->only('class')->merge(['class' => 'inline-flex items-center ' . $wrapperClasses]) }}
>
    <input
        {{ $inputAttributes }}
        x-ref="input"
        type="hidden"
        data-pegboard-control
    />

    <div class="relative inline-flex items-center gap-2">
        <div class="inline-flex items-center">
            <template x-for="star in maxStars" :key="star">
                <button
                    type="button"
                    @mouseenter="hoverStar(star)"
                    @mouseleave="resetHover"
                    @click="rate(star)"
                    :disabled="disabled"
                    class="px-0.5 transition-transform duration-fast focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 rounded"
                    :class="{
                        'cursor-pointer hover:scale-110 active:scale-95': !disabled,
                        'cursor-not-allowed opacity-disabled': disabled
                    }"
                >
                    <x-pegboard::icon
                        :name="$icon"
                        variant="outline"
                        x-show="star > stars"
                        x-cloak
                        :class="$sizeClasses . ' text-muted-foreground transition-colors duration-fast'"
                    />

                    <x-pegboard::icon
                        :name="$icon"
                        variant="solid"
                        x-show="star <= stars"
                        x-cloak
                        :class="$sizeClasses . ' ' . $variantClasses . ' fill-current transition-colors duration-fast'"
                    />
                </button>
            </template>
        </div>

        @if($showValue)
            <div
                x-ref="valueDisplay"
                x-show="value > 0"
                x-cloak
                x-text="`Rated ${value}`"
                class="text-sm font-medium text-foreground transition-opacity duration-fast"
            ></div>
        @endif

        @if($showReset)
            <button
                type="button"
                x-show="value > 0"
                x-cloak
                @click="reset"
                :disabled="disabled"
                class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs rounded-full transition-colors duration-fast focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
                :class="{
                    'bg-muted text-muted-foreground hover:bg-destructive hover:text-destructive-foreground cursor-pointer': !disabled,
                    'cursor-not-allowed opacity-disabled': disabled
                }"
            >
                <x-pegboard::icon name="x-mark" variant="solid" class="w-3 h-3" />
            </button>
        @endif
    </div>
</div>
