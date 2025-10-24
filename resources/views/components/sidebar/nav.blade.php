@php
$baseClasses = implode(' ', [
    'flex-1 overflow-y-auto overflow-x-hidden',
    'px-3 py-4',
    'space-y-1',
    'scrollbar-thin',
]);

$mergedClasses = $attributes->merge(['class' => $baseClasses])->get('class');
@endphp

<nav {{ $attributes->merge(['class' => $mergedClasses]) }}>
    {{ $slot }}
</nav>
