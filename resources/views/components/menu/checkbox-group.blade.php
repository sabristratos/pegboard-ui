<div
    x-data="pegboardCheckboxGroup({ name: null, value: @js($value) })"
    x-modelable="selectedValues"
    {{ $attributes }}
>
    {{ $slot }}
</div>
