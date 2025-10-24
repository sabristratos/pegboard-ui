@php
    $layoutClasses = match($variant) {
        'inline' => '@container flex items-start gap-4 @max-xs:flex-col @max-xs:gap-3',
        default => '@container flex flex-col gap-3',
    };

    $baseClasses = $layoutClasses;
@endphp

<div data-slot="field" {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</div>
