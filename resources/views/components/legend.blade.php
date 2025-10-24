@php
    $baseClasses = 'text-base font-semibold text-foreground';
@endphp

<legend data-slot="legend" {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</legend>
