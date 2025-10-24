@props([
    'size' => 'sm',
])

@php
$sizeClasses = match ($size) {
    'xs' => 'px-1 py-0.5 text-[10px]',
    'sm' => 'px-1.5 py-0.5 text-xs',
    'md' => 'px-2 py-1 text-sm',
    default => 'px-1.5 py-0.5 text-xs',
};

$baseClasses = implode(' ', [
    'font-mono',
    'bg-muted',
    'border border-border',
    'rounded',
    'inline-flex items-center justify-center',
    'select-none',
    $sizeClasses,
]);

$mergedClasses = $attributes->merge(['class' => $baseClasses])->get('class');
@endphp

<kbd {{ $attributes->merge(['class' => $mergedClasses]) }}>
    {{ $slot }}
</kbd>
