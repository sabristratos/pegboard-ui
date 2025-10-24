<div
    x-data="pegboardRadioGroup({ name: null, value: @js($value) })"
    x-modelable="selectedValue"
    {{ $attributes }}
>
    {{ $slot }}
</div>
