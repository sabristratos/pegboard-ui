@php
    // Base classes for table header with solid background (important for sticky headers)
    $baseClasses = 'border-b border-border bg-table-header';
@endphp

<thead {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</thead>
