@props(['size' => 'md'])

@php
$sizeClasses = match($size) {
    'sm' => 'text-2xl',
    'md' => 'text-4xl',
    'lg' => 'text-6xl',
    'xl' => 'text-8xl',
    default => 'text-4xl',
};
@endphp

<div
    data-pegboard-timer-display
    class="font-mono font-bold tabular-nums {{ $sizeClasses }} text-foreground"
    x-text="formattedTime"
    :aria-label="`${mode === 'countdown' ? 'Time remaining' : 'Elapsed time'}: ${formattedTime}`"
>
    {{ $slot ?? '00:00' }}
</div>
