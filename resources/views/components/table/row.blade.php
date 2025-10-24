@php
    // Base classes - hover is controlled by parent table component
    $baseClasses = 'border-b border-border last:border-b-0';
@endphp

<tr {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</tr>
