@php
    $baseClasses = '-mx-1 my-1 h-px bg-border';
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}></div>
