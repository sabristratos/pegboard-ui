@props([
    'duration' => 60,
    'mode' => 'countdown',
    'autostart' => false,
    'disabled' => false,
    'showHours' => true,
    'size' => 'md',
])

@php
$duration = (int) $duration;
$mode = (string) $mode;
$autostart = (bool) $autostart;
$disabled = (bool) $disabled;
$showHours = (bool) $showHours;
$size = (string) $size;

$containerClasses = match($size) {
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
    'xl' => 'p-10',
    default => 'p-6',
};
@endphp

<div
    x-data="timer({
        duration: {{ $duration }},
        mode: '{{ $mode }}',
        autostart: {{ $autostart ? 'true' : 'false' }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        showHours: {{ $showHours ? 'true' : 'false' }}
    })"
    data-pegboard-timer
    :data-timer-mode="mode"
    :data-timer-running="isRunning ? '' : undefined"
    :data-timer-paused="isPaused ? '' : undefined"
    :data-timer-disabled="disabled ? '' : undefined"
    {{ $attributes->merge(['class' => 'flex flex-col items-center gap-6 rounded-lg border border-border bg-card text-card-foreground shadow-sm ' . $containerClasses]) }}
    role="timer"
    :aria-label="`${mode === 'countdown' ? 'Countdown timer' : 'Stopwatch'}: ${formattedTime}`"
    aria-live="polite"
>
    @if (isset($display))
        {{ $display }}
    @else
        <x-pegboard::timer.display :size="$size" />
    @endif

    @if (isset($controls))
        {{ $controls }}
    @else
        <x-pegboard::timer.controls :size="$size" />
    @endif

    @if ($slot->isNotEmpty())
        <div class="w-full">
            {{ $slot }}
        </div>
    @endif
</div>
