@php
    $baseClasses = 'flex items-center gap-2 w-full px-3 py-2 text-sm rounded cursor-pointer transition-colors duration-fast outline-none text-foreground hover:bg-accent hover:text-accent-foreground data-[active]:bg-accent data-[active]:text-accent-foreground';
    $disabledClasses = 'opacity-50 cursor-not-allowed pointer-events-none';
    $radioId = 'radio-' . uniqid();
@endphp

<label
    x-data="{
        ...pegboardRadio({ value: @js($value), disabled: {{ $disabled ? 'true' : 'false' }} }),
        ...menuItem({ disabled: {{ $disabled ? 'true' : 'false' }}, keepOpen: {{ $keepOpen ? 'true' : 'false' }} })
    }"
    :data-checked="checked"
    class="{{ $baseClasses }}{{ $disabled ? ' ' . $disabledClasses : '' }}"
>
    <input
        type="radio"
        id="{{ $radioId }}"
        :name="groupName"
        :value="@js($value)"
        {{ $checked ? 'checked' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->whereStartsWith('wire:model') }}
        :checked="checked"
        @change="select"
        class="appearance-none shrink-0 w-4 h-4 rounded-full border border-border bg-background cursor-pointer transition-all duration-fast m-0 relative hover:border-primary/60 checked:border-primary checked:bg-background disabled:cursor-not-allowed disabled:opacity-50 focus-visible:outline-2 focus-visible:outline-ring focus-visible:outline-offset-2 before:absolute before:top-1/2 before:left-1/2 before:-translate-x-1/2 before:-translate-y-1/2 before:w-2 before:h-2 before:rounded-full before:bg-primary before:scale-0 before:opacity-0 before:transition-[transform,opacity] before:duration-fast checked:before:scale-100 checked:before:opacity-100"
    />

    <span class="flex-1">
        {{ $slot }}
    </span>
</label>
