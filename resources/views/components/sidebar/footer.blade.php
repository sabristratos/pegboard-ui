@php
$baseClasses = implode(' ', [
    'shrink-0 border-t border-sidebar-border',
    'px-4 py-4',
]);

$mergedClasses = $attributes->merge(['class' => $baseClasses])->get('class');
@endphp

<div {{ $attributes->merge(['class' => $mergedClasses]) }}>
    {{ $slot }}
</div>
