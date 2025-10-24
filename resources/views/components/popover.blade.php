@php
    use Stratos\Pegboard\Support\PopoverPositioning;

    $popoverId = $attributes->get('popover-id') ?? 'popover-' . uniqid();
    $config = PopoverPositioning::getConfiguration($popoverId, $placement, $offset);

    $anchorName = $config['anchor'];
    $positionStyles = $config['styles'];
    $baseClasses = $config['base'] . ' ' . $config['transition'];
@endphp

<div
    x-data="popover({ trigger: '{{ $trigger }}', placement: '{{ $placement }}', offset: {{ $offset }} })"
    data-trigger="{{ $trigger }}"
    data-placement="{{ $placement }}"
    class="inline-block"
>
    <span
        x-ref="trigger"
        @if($trigger === 'click')
            @click="toggle()"
        @elseif($trigger === 'hover')
            @mouseenter="open()"
            @mouseleave="close()"
        @endif
        popovertarget="{{ $popoverId }}"
        :data-open="isOpen"
        class="inline-flex"
        style="anchor-name: {{ $anchorName }};"
    >
        {{ $button }}
    </span>

    <div
        x-ref="popover"
        id="{{ $popoverId }}"
        popover
        {{ $attributes->merge(['class' => $baseClasses . ' z-50']) }}
        style="{{ $positionStyles }}"
        :data-open="isOpen"
        @if($trigger === 'hover')
            @mouseenter="keepOpen()"
            @mouseleave="close()"
        @endif
    >
        {{ $slot }}
    </div>
</div>
