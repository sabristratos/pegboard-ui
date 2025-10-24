@php
    $baseClasses = 'text-sm font-medium text-foreground';

    $layoutClasses = $tooltip ? 'flex items-center gap-2' : '';

    $finalClasses = trim($baseClasses . ' ' . $layoutClasses);
@endphp

<label
    data-slot="label"
    {{ $attributes->merge([
        'for' => $for,
        'class' => $finalClasses
    ]) }}
>
    {{ $slot }}

    @if($tooltip)
        <x-pegboard::tooltip :text="$tooltip" placement="top">
            <x-pegboard::icon name="information-circle" class="h-4 w-4 text-muted-foreground" />
        </x-pegboard::tooltip>
    @endif
</label>
