<div x-data="{ show: false }" class="inline-block" {{ $attributes->only(['class', 'style']) }}>
    <span
        popovertarget="{{ $tooltipId }}"
        @mouseenter="show = true; $refs.tooltip.showPopover()"
        @mouseleave="show = false; $refs.tooltip.hidePopover()"
        class="inline-flex"
        style="anchor-name: {{ $popoverConfig['anchor'] }};"
    >
        {{ $slot }}
    </span>

    <div
        x-ref="tooltip"
        id="{{ $tooltipId }}"
        popover="hint"
        class="{{ $popoverConfig['base'] }} {{ $popoverConfig['transition'] }} {{ $popoverConfig['origin'] }} bg-popover text-popover-foreground text-sm px-3 py-1.5 rounded max-w-xs shadow-lg z-50"
        style="{{ $popoverConfig['styles'] }}"
    >
        {{ $text }}
    </div>
</div>
