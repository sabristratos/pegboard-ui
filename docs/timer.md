# Timer Component

A flexible timer component supporting both countdown and stopwatch modes with full playback controls, event dispatching, and Livewire integration.

## Features

- Countdown timer (counts down to zero)
- Stopwatch mode (counts up from zero)
- Full playback controls (Start, Pause, Resume, Reset)
- 4 size variants (sm, md, lg, xl)
- Auto-start option
- Event dispatching for Livewire integration
- Customizable display and controls via slots
- Adaptive time format (HH:MM:SS or MM:SS)
- Automatic cleanup on component destruction

## Basic Usage

### Simple Countdown Timer

```blade
{{-- 5-minute countdown timer --}}
<x-pegboard::timer duration="300" />

{{-- 1-minute countdown timer --}}
<x-pegboard::timer duration="60" />

{{-- 30-second countdown timer --}}
<x-pegboard::timer duration="30" />
```

### Stopwatch Mode

```blade
{{-- Counts up from 00:00 --}}
<x-pegboard::timer mode="stopwatch" />
```

### Auto-Start Timer

```blade
{{-- Starts countdown automatically on page load --}}
<x-pegboard::timer duration="120" autostart />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `duration` | int | `60` | Timer duration in seconds (for countdown mode) |
| `mode` | string | `'countdown'` | Timer mode: `countdown` or `stopwatch` |
| `autostart` | bool | `false` | Start timer automatically on mount |
| `disabled` | bool | `false` | Disable all timer controls |
| `showHours` | bool | `true` | Show hours in display (auto-hides if duration < 1 hour) |
| `size` | string | `'md'` | Size: `sm`, `md`, `lg`, `xl` |

## Size Variants

```blade
{{-- Small (compact for cards) --}}
<x-pegboard::timer size="sm" duration="60" />

{{-- Medium (default) --}}
<x-pegboard::timer size="md" duration="120" />

{{-- Large (prominent display) --}}
<x-pegboard::timer size="lg" duration="180" />

{{-- Extra Large (full-screen timers) --}}
<x-pegboard::timer size="xl" duration="300" />
```

**Size affects:**
- Time display font size
- Button sizes
- Container padding
- Overall component scale

## Timer Modes

### Countdown Mode

Counts down from a specified duration to zero:

```blade
{{-- Basic countdown --}}
<x-pegboard::timer duration="300" mode="countdown" />

{{-- 10-minute exam timer --}}
<x-pegboard::timer duration="600" autostart />

{{-- Pomodoro timer (25 minutes) --}}
<x-pegboard::timer duration="1500" />
```

**Behavior:**
- Starts at specified duration
- Counts down: 05:00 → 04:59 → ... → 00:00
- Dispatches `timer:complete` event when reaching zero
- Automatically stops at 00:00

### Stopwatch Mode

Counts up from zero indefinitely:

```blade
{{-- Basic stopwatch --}}
<x-pegboard::timer mode="stopwatch" />

{{-- Auto-start stopwatch --}}
<x-pegboard::timer mode="stopwatch" autostart />
```

**Behavior:**
- Starts at 00:00
- Counts up: 00:00 → 00:01 → ... → infinity
- No automatic stop (manual control only)
- Useful for tracking elapsed time

## Time Display Format

The timer automatically adapts its display format:

**Short durations (< 1 hour):**
```blade
<x-pegboard::timer duration="59" />
{{-- Displays: 00:59 (MM:SS) --}}
```

**Long durations (≥ 1 hour):**
```blade
<x-pegboard::timer duration="3661" />
{{-- Displays: 01:01:01 (HH:MM:SS) --}}
```

**Force hours display:**
```blade
<x-pegboard::timer duration="30" :show-hours="true" />
{{-- Displays: 00:00:30 (always shows hours) --}}
```

**Hide hours:**
```blade
<x-pegboard::timer duration="7200" :show-hours="false" />
{{-- Displays: 120:00 (MM:SS even for 2 hours) --}}
```

## Events

The timer dispatches Alpine.js events that you can listen to for Livewire integration:

### Available Events

| Event | Payload | Description |
|-------|---------|-------------|
| `timer:start` | `{ mode, time }` | Timer started |
| `timer:pause` | `{ mode, time }` | Timer paused |
| `timer:resume` | `{ mode, time }` | Timer resumed |
| `timer:reset` | `{ mode, time }` | Timer reset to initial state |
| `timer:tick` | `{ mode, time }` | Fired every second while running |
| `timer:complete` | `{ mode }` | Countdown reached zero |

### Event Listeners

```blade
{{-- Log timer events to console --}}
<x-pegboard::timer
    duration="10"
    @timer:start="console.log('Timer started')"
    @timer:tick="console.log('Tick:', $event.detail.time)"
    @timer:complete="console.log('Timer complete!')"
/>
```

### Livewire Integration

```blade
{{-- Trigger Livewire actions on timer events --}}
<x-pegboard::timer
    duration="300"
    autostart
    @timer:complete="$wire.handleTimerComplete()"
    @timer:tick="$wire.updateProgress($event.detail.time)"
/>
```

```php
namespace App\Livewire;

use Livewire\Component;

class ExamTimer extends Component
{
    public function handleTimerComplete()
    {
        // Auto-submit exam when timer expires
        $this->submitExam();
    }

    public function updateProgress($timeRemaining)
    {
        // Update progress bar or UI
        $this->timeRemaining = $timeRemaining;
    }
}
```

## Custom Display

Override the default time display using the `display` slot:

```blade
<x-pegboard::timer duration="120">
    <x-slot:display>
        <div class="text-center">
            {{-- Custom heading --}}
            <p class="text-xs text-muted-foreground mb-2">Time Remaining</p>

            {{-- Custom time display --}}
            <div class="font-mono font-bold text-5xl text-primary" x-text="formattedTime">
                00:00
            </div>

            {{-- Status indicator --}}
            <p class="text-xs text-muted-foreground mt-2" x-text="isRunning ? 'Running...' : (isPaused ? 'Paused' : 'Ready')">
            </p>
        </div>
    </x-slot:display>
</x-pegboard::timer>
```

**Available Alpine.js variables in display slot:**
- `formattedTime` - Formatted time string (e.g., "05:30")
- `timeRemaining` - Raw seconds (e.g., 330)
- `isRunning` - Boolean, true if timer is active
- `isPaused` - Boolean, true if timer is paused
- `mode` - String, "countdown" or "stopwatch"

## Custom Controls

Override the default control buttons using the `controls` slot:

```blade
<x-pegboard::timer duration="120">
    <x-slot:controls>
        <div class="flex gap-2">
            {{-- Custom start button --}}
            <template x-if="!isRunning && !isPaused">
                <button
                    @click="start"
                    class="px-4 py-2 bg-green-500 text-white rounded"
                >
                    Go!
                </button>
            </template>

            {{-- Custom pause button --}}
            <template x-if="isRunning">
                <button
                    @click="pause"
                    class="px-4 py-2 bg-yellow-500 text-white rounded"
                >
                    Pause
                </button>
            </template>

            {{-- Custom reset button --}}
            <button
                @click="reset"
                class="px-4 py-2 bg-red-500 text-white rounded"
            >
                Reset
            </button>
        </div>
    </x-slot:controls>
</x-pegboard::timer>
```

**Available Alpine.js methods in controls slot:**
- `start()` - Start the timer
- `pause()` - Pause the timer
- `resume()` - Resume the timer
- `reset()` - Reset to initial state
- All variables from display slot

## Additional Content

Add extra content below the controls using the default slot:

```blade
<x-pegboard::timer duration="300">
    {{-- Extra content goes here --}}
    <div class="mt-4 p-4 bg-muted/50 rounded-lg text-center">
        <p class="text-sm text-muted-foreground">
            Complete the task before time runs out!
        </p>
    </div>
</x-pegboard::timer>
```

## Real-World Examples

### Exam Timer

```blade
<div class="max-w-md mx-auto">
    <h2 class="text-2xl font-bold text-center mb-4">Final Exam</h2>

    <x-pegboard::timer
        duration="3600"
        size="lg"
        autostart
        @timer:complete="$wire.submitExam()"
        @timer:tick="$wire.updateTimeRemaining($event.detail.time)"
    />

    <p class="text-center text-sm text-muted-foreground mt-4">
        Your answers will be auto-submitted when time expires
    </p>
</div>
```

### Workout Interval Timer

```blade
<x-pegboard::timer
    duration="30"
    autostart
    @timer:complete="$wire.nextExercise()"
>
    <x-slot:display>
        <div class="text-center">
            <p class="text-lg font-semibold mb-2" x-text="'Exercise: ' + $wire.currentExercise"></p>
            <div class="text-6xl font-bold text-primary" x-text="formattedTime"></div>
        </div>
    </x-slot:display>

    <div class="mt-4 text-center">
        <p class="text-sm text-muted-foreground">Next: <span x-text="$wire.nextExerciseName"></span></p>
    </div>
</x-pegboard::timer>
```

### Task Time Tracker

```blade
<div class="p-6 border border-border rounded-lg">
    <h3 class="text-lg font-semibold mb-4">Time Tracking</h3>

    <x-pegboard::timer
        mode="stopwatch"
        size="md"
        @timer:start="$wire.startTask()"
        @timer:pause="$wire.pauseTask()"
        @timer:reset="$wire.resetTask()"
    />

    <div class="mt-4">
        <label class="text-sm font-medium">Task Description</label>
        <input
            type="text"
            wire:model="taskDescription"
            class="w-full mt-1 px-3 py-2 border border-border rounded-md"
        />
    </div>

    <button
        wire:click="saveTimeEntry"
        class="mt-4 w-full px-4 py-2 bg-primary text-white rounded-md"
    >
        Save Time Entry
    </button>
</div>
```

### Pomodoro Timer

```blade
<div class="text-center">
    <h2 class="text-2xl font-bold mb-6">Pomodoro Timer</h2>

    <x-pegboard::timer
        :duration="$isBreak ? 300 : 1500"
        size="xl"
        @timer:complete="$wire.toggleMode()"
    >
        <x-slot:display>
            <div class="text-center">
                <p class="text-sm font-semibold mb-2" x-text="$wire.isBreak ? 'BREAK TIME' : 'WORK TIME'"></p>
                <div class="font-mono font-bold text-8xl" x-text="formattedTime"></div>
            </div>
        </x-slot:display>
    </x-pegboard::timer>

    <div class="mt-6 flex justify-center gap-4">
        <div class="text-center">
            <p class="text-2xl font-bold" x-text="$wire.completedPomodoros"></p>
            <p class="text-xs text-muted-foreground">Completed</p>
        </div>
    </div>
</div>
```

### Auction Countdown

```blade
<div class="bg-card border border-border rounded-lg p-6">
    <h3 class="text-xl font-bold mb-4">Auction Ending Soon!</h3>

    <x-pegboard::timer
        :duration="$timeRemaining"
        autostart
        @timer:complete="$wire.closeAuction()"
    >
        <x-slot:display>
            <div class="flex items-center gap-4">
                <svg class="w-8 h-8 text-destructive" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm text-muted-foreground">Time Remaining</p>
                    <p class="text-3xl font-bold text-destructive" x-text="formattedTime"></p>
                </div>
            </div>
        </x-slot:display>
    </x-pegboard::timer>

    <div class="mt-4 flex items-center justify-between">
        <div>
            <p class="text-sm text-muted-foreground">Current Bid</p>
            <p class="text-2xl font-bold">${{ number_format($currentBid, 2) }}</p>
        </div>
        <x-pegboard::button wire:click="placeBid">
            Place Bid
        </x-pegboard::button>
    </div>
</div>
```

## Accessibility

The timer component is fully accessible:

**Keyboard Navigation:**
- All controls are keyboard accessible
- `Tab` - Navigate between buttons
- `Enter` or `Space` - Activate buttons
- Standard button keyboard behavior

**Screen Reader Support:**
- Descriptive ARIA labels on all buttons
- `role="timer"` on main container
- `aria-label` describes current mode and time
- `aria-live="polite"` announces time changes

**Visual Accessibility:**
- High contrast text and borders
- Focus visible indicators
- Clear button states
- Works without color alone

## Best Practices

### 1. Use Appropriate Durations

```blade
{{-- ✅ Good - Reasonable durations --}}
<x-pegboard::timer duration="300" />  <!-- 5 minutes -->
<x-pegboard::timer duration="1800" /> <!-- 30 minutes -->

{{-- ❌ Avoid - Extremely long durations --}}
<x-pegboard::timer duration="86400" /> <!-- 24 hours -->
```

### 2. Choose the Right Mode

```blade
{{-- ✅ Good - Countdown for deadlines --}}
<x-pegboard::timer duration="600" mode="countdown" />

{{-- ✅ Good - Stopwatch for tracking --}}
<x-pegboard::timer mode="stopwatch" />
```

### 3. Match Size to Context

```blade
{{-- ✅ Card/compact space - use small --}}
<x-pegboard::timer size="sm" />

{{-- ✅ Main focus - use large/xl --}}
<x-pegboard::timer size="xl" />
```

### 4. Use Events for Important Actions

```blade
{{-- ✅ Good - Handle completion --}}
<x-pegboard::timer
    duration="300"
    @timer:complete="$wire.submitForm()"
/>

{{-- ❌ Bad - No completion handler for critical timer --}}
<x-pegboard::timer duration="300" />
```

### 5. Provide Context

```blade
{{-- ✅ Good - Clear purpose --}}
<div class="text-center">
    <h3 class="text-lg font-semibold mb-4">Quiz Time Remaining</h3>
    <x-pegboard::timer duration="600" autostart />
</div>

{{-- ❌ Bad - No context --}}
<x-pegboard::timer duration="600" />
```

### 6. Disable When Needed

```blade
{{-- ✅ Good - Disable during processing --}}
<x-pegboard::timer
    duration="300"
    :disabled="$isProcessing"
/>
```

## Customization

Pass custom classes to style the container:

```blade
{{-- Custom spacing --}}
<x-pegboard::timer class="mx-auto" duration="120" />

{{-- Custom width --}}
<x-pegboard::timer class="max-w-md" duration="120" />

{{-- Custom background --}}
<x-pegboard::timer class="bg-gradient-to-br from-purple-50 to-pink-50" duration="120" />
```
