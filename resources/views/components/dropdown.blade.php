@php
    use Stratos\Pegboard\Support\PopoverPositioning;

    $menuId = $attributes->get('menu-id') ?? 'menu-' . uniqid();
    $computedPlacement = $align === 'center' ? $position : "$position-$align";
    $computedOffset = $offset + $gap;
    $popoverConfig = PopoverPositioning::getConfiguration($menuId, $computedPlacement, $computedOffset);
    $menuClass = $attributes->get('menu-class', '');
@endphp

<div
    x-data="dropdown({ position: '{{ $position }}', align: '{{ $align }}', offset: {{ $offset }}, gap: {{ $gap }} })"
    @menu-close.window="if ($event.target.closest('[x-data]') === $el) close()"
    data-position="{{ $position }}"
    data-align="{{ $align }}"
    {{ $attributes->except('menu-class')->merge(['class' => 'inline-block']) }}
>
    <span
        x-ref="trigger"
        @click.stop="toggle()"
        :data-open="open"
        popovertarget="{{ $menuId }}"
        class="inline-flex"
        style="anchor-name: {{ $popoverConfig['anchor'] }};"
    >
        {{ $slot }}
    </span>

    <div
        x-ref="menu"
        @click.outside="close()"
        @keydown.escape="close(); $refs.trigger.focus()"
        popover="auto"
        id="{{ $menuId }}"
        :data-open="open"
        class="{{ $popoverConfig['base'] }} {{ $popoverConfig['transition'] }} {{ $popoverConfig['origin'] }} {{ $menuClass }}"
        style="{{ $popoverConfig['styles'] }}"
        tabindex="-1"
    >
        {{ $menu ?? '' }}
    </div>
</div>
