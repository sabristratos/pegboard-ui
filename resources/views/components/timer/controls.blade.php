@props(['size' => 'md'])

@php
$buttonSize = match($size) {
    'sm' => 'sm',
    'md' => 'md',
    'lg' => 'lg',
    'xl' => 'lg',
    default => 'md',
};
@endphp

<div
    data-pegboard-timer-controls
    class="flex items-center justify-center gap-2"
>
    <template x-if="!isRunning && !isPaused">
        <x-pegboard::button
            type="button"
            @click="start"
            x-bind:disabled="disabled"
            variant="primary"
            icon="play"
            :size="$buttonSize"
            aria-label="Start timer"
        >
            Start
        </x-pegboard::button>
    </template>

    <template x-if="isRunning && !isPaused">
        <x-pegboard::button
            type="button"
            @click="pause"
            x-bind:disabled="disabled"
            variant="primary"
            icon="pause"
            :size="$buttonSize"
            aria-label="Pause timer"
        >
            Pause
        </x-pegboard::button>
    </template>

    <template x-if="!isRunning && isPaused">
        <x-pegboard::button
            type="button"
            @click="resume"
            x-bind:disabled="disabled"
            variant="primary"
            icon="play"
            :size="$buttonSize"
            aria-label="Resume timer"
        >
            Resume
        </x-pegboard::button>
    </template>

    <x-pegboard::button
        type="button"
        @click="reset"
        x-bind:disabled="disabled"
        variant="outline"
        icon="arrow-path"
        :size="$buttonSize"
        aria-label="Reset timer"
    >
        Reset
    </x-pegboard::button>
</div>
