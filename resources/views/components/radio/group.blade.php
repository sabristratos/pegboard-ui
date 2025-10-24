@php
    if (!isset($name)) {
        $name = $attributes->whereStartsWith('wire:model')->first();
    }

    $orientationClasses = $orientation === 'horizontal' ? 'flex-row' : 'flex-col';
@endphp

<div
    x-data="pegboardRadioGroup({
        name: @js($name),
        value: @js($value)
    })"
    x-modelable="selectedValue"
    {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}
    role="radiogroup"
    :aria-orientation="'{{ $orientation }}'"
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
        <input type="hidden" :name="'{{ $name }}'" x-model="selectedValue" />
    @endif
</div>
