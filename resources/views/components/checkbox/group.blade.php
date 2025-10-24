@php
    $orientationClasses = $orientation === 'horizontal' ? 'flex-row' : 'flex-col';
@endphp

<div
    x-data="pegboardCheckboxGroup({
        name: @js($name),
        value: @js($value)
    })"
    x-modelable="selectedValues"
    {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}
    role="group"
>
    @if($label)
        <span class="text-sm font-medium text-foreground">{{ $label }}</span>
    @endif

    <div class="flex {{ $orientationClasses }} flex-wrap gap-2" role="presentation">
        {{ $slot }}
    </div>

    @if($description)
        <p class="text-sm text-muted-foreground">{{ $description }}</p>
    @endif

    @if($name)
        <template x-for="(val, index) in selectedValues" :key="index">
            <input type="hidden" :name="'{{ $name }}' + '[]'" :value="val" />
        </template>
    @endif
</div>
