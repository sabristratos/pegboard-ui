@php
    $triggerClasses = 'flex items-center gap-2 w-full px-3 py-2 text-sm rounded cursor-pointer transition-colors duration-fast outline-none text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground data-[active]:bg-popover-hover data-[active]:text-popover-hover-foreground active:bg-popover-hover/90';
    $submenuClasses = 'min-w-56 bg-popover text-popover-foreground border border-border rounded-lg shadow-lg p-1 flex flex-col gap-1 overflow-hidden';
@endphp

<div x-data="submenu({ heading: '{{ $heading }}', keepOpen: {{ $keepOpen ? 'true' : 'false' }} })">
    <button
        type="button"
        x-ref="trigger"
        @click="handleTriggerClick()"
        @mouseenter="openSubmenu()"
        @mouseleave="closeDelayed()"
        @keydown.right="openSubmenu()"
        popovertarget="{{ $submenuId }}"
        style="anchor-name: {{ $popoverConfig['anchor'] }};"
        class="{{ $triggerClasses }}"
    >
        @if($icon)
            <x-pegboard::icon :name="$icon" :variant="$iconVariant" class="h-4 w-4 shrink-0" />
        @endif

        <span class="flex-1 text-left">
            {{ $heading }}
        </span>

        @if($iconTrailing)
            <x-pegboard::icon :name="$iconTrailing" :variant="$iconVariant" class="h-4 w-4 shrink-0" />
        @else
            <x-pegboard::icon name="chevron-right" variant="mini" class="h-4 w-4 shrink-0" />
        @endif
    </button>

    <div
        x-ref="submenu"
        x-show="open"
        @click.outside="close()"
        @keydown.escape="close(); $refs.trigger.focus()"
        @keydown.down.prevent="navigateDown"
        @keydown.up.prevent="navigateUp"
        @keydown.left="navigateLeft()"
        @keydown.enter.prevent="selectActive"
        popover="manual"
        id="{{ $submenuId }}"
        @mouseenter="cancelClose()"
        @mouseleave="closeDelayed()"
        class="{{ $popoverConfig['base'] }} {{ $popoverConfig['transition'] }} {{ $popoverConfig['origin'] }} {{ $submenuClasses }}"
        style="{{ $popoverConfig['styles'] }}"
        tabindex="-1"
    >
        {{ $slot }}
    </div>
</div>
