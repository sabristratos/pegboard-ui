@php
    $baseClasses = 'border-t border-border bg-muted/50 font-medium';
@endphp

<tfoot {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</tfoot>
