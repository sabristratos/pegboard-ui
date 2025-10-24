@php
    $baseClasses = 'text-sm text-muted-foreground';
@endphp

<p data-slot="description" {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</p>
