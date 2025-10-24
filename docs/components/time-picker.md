# TimePicker Component

A time picker with 12/24 hour format support, scrollable hour/minute selection, validation states, and full Livewire compatibility.

## Basic Usage

```blade
<x-pegboard::time-picker placeholder="Select time..." />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Visual variant: `'default'`, `'error'`, `'success'` |
| `size` | string | `'md'` | Size variant: `'xs'`, `'sm'`, `'md'`, `'lg'` |
| `format` | string | `'12'` | Time format: `'12'` (12-hour) or `'24'` (24-hour) |
| `step` | int | `5` | Minute step interval (e.g., 5, 15, 30) |
| `clearable` | bool | `false` | Shows a clear button when time is selected |
| `disabled` | bool | `false` | Disables the time picker |
| `placeholder` | string | Auto | Placeholder text (auto-generated based on format) |
| `name` | string\|null | `null` | Form field name |
| `value` | string\|null | `null` | Initial selected time value |

## Variants

TimePickers support three validation variants for visual feedback:

```blade
<!-- Default state -->
<x-pegboard::time-picker variant="default" placeholder="Select time..." />

<!-- Error state -->
<x-pegboard::time-picker variant="error" placeholder="Required field" />
<p class="text-sm text-destructive mt-1">Time is required</p>

<!-- Success state -->
<x-pegboard::time-picker variant="success" value="14:30" />
<p class="text-sm text-success mt-1">Valid time selected</p>
```

## Sizes

Four size options are available to match your design:

```blade
<!-- Extra Small -->
<x-pegboard::time-picker size="xs" placeholder="XS Time" />

<!-- Small -->
<x-pegboard::time-picker size="sm" placeholder="SM Time" />

<!-- Medium (Default) -->
<x-pegboard::time-picker size="md" placeholder="MD Time" />

<!-- Large -->
<x-pegboard::time-picker size="lg" placeholder="LG Time" />
```

## Time Formats

Choose between 12-hour and 24-hour time formats:

```blade
<!-- 12-hour format with AM/PM -->
<x-pegboard::time-picker
    format="12"
    placeholder="12:00 PM"
/>

<!-- 24-hour format -->
<x-pegboard::time-picker
    format="24"
    placeholder="13:00"
/>
```

## Minute Step Intervals

Customize the minute increment intervals:

```blade
<!-- 5-minute intervals (default) -->
<x-pegboard::time-picker :step="5" />

<!-- 15-minute intervals -->
<x-pegboard::time-picker :step="15" placeholder="15 min intervals" />

<!-- 30-minute intervals -->
<x-pegboard::time-picker :step="30" placeholder="30 min intervals" />

<!-- 1-minute intervals -->
<x-pegboard::time-picker :step="1" placeholder="Every minute" />
```

## Clearable

Add a clear button that appears when a time is selected:

```blade
<x-pegboard::time-picker
    clearable
    value="14:30"
    placeholder="Select time..."
/>
```

## Disabled State

Disable the time picker to make it read-only:

```blade
<!-- Disabled empty -->
<x-pegboard::time-picker disabled placeholder="Cannot select..." />

<!-- Disabled with value -->
<x-pegboard::time-picker disabled value="09:15" />

<!-- Disabled with validation state -->
<x-pegboard::time-picker disabled variant="success" value="14:30" />
```

## Form Submission

The TimePicker component works with traditional form submissions and Livewire:

### Traditional Forms

```blade
<form action="/submit" method="POST">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-2">Appointment Time</label>
        <x-pegboard::time-picker
            name="appointment_time"
            format="12"
            :step="15"
            placeholder="Select time..."
        />
    </div>

    <button type="submit">Submit</button>
</form>
```

### Livewire Integration

```blade
<!-- Two-way binding -->
<x-pegboard::time-picker
    wire:model="appointmentTime"
    placeholder="Select time..."
/>

<!-- Live binding -->
<x-pegboard::time-picker
    wire:model.live="startTime"
    format="24"
    placeholder="Start time..."
/>

<!-- Blur binding -->
<x-pegboard::time-picker
    wire:model.blur="endTime"
    placeholder="End time..."
/>
```

## Real-World Examples

### Appointment Scheduler

```blade
<div class="max-w-md space-y-4">
    <div>
        <label class="block text-sm font-medium mb-2">Appointment Time</label>
        <x-pegboard::time-picker
            wire:model="appointment.time"
            format="12"
            :step="15"
            clearable
            variant="{{ $errors->has('appointment.time') ? 'error' : 'default' }}"
            placeholder="Select time..."
        />
        @error('appointment.time')
            <p class="text-sm text-destructive mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
```

### Business Hours Configuration

```blade
<div class="space-y-4">
    <h3 class="text-lg font-semibold">Business Hours</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-2">Opening Time</label>
            <x-pegboard::time-picker
                wire:model.live="hours.open"
                format="12"
                :step="30"
                clearable
                placeholder="Opens at..."
            />
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Closing Time</label>
            <x-pegboard::time-picker
                wire:model.live="hours.close"
                format="12"
                :step="30"
                clearable
                placeholder="Closes at..."
            />
        </div>
    </div>

    @if($hours->open && $hours->close)
        <p class="text-sm text-muted-foreground">
            Business hours: {{ $hours->open }} - {{ $hours->close }}
        </p>
    @endif
</div>
```

### Event Time Range

```blade
<div class="max-w-2xl space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-2">Start Time</label>
            <x-pegboard::time-picker
                wire:model="event.start_time"
                format="24"
                :step="5"
                clearable
            />
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">End Time</label>
            <x-pegboard::time-picker
                wire:model="event.end_time"
                format="24"
                :step="5"
                clearable
            />
        </div>
    </div>
</div>
```

### Reminder Time Selector

```blade
<div>
    <label class="block text-sm font-medium mb-2">Reminder Time</label>
    <x-pegboard::time-picker
        name="reminder_time"
        format="12"
        size="lg"
        clearable
        placeholder="When should we remind you?"
        variant="{{ $errors->has('reminder_time') ? 'error' : 'success' }}"
    />
</div>
```

### Meeting Schedule (Multiple Times)

```blade
<div class="max-w-md space-y-3">
    <label class="block text-sm font-medium">Meeting Times</label>

    @foreach($meetingTimes as $index => $time)
        <div class="flex gap-2 items-center">
            <x-pegboard::time-picker
                wire:model="meetingTimes.{{ $index }}"
                format="12"
                :step="15"
                clearable
                size="sm"
            />
            <button
                wire:click="removeTime({{ $index }})"
                type="button"
                class="text-destructive hover:text-destructive/80"
            >
                Remove
            </button>
        </div>
    @endforeach

    <button
        wire:click="addTime"
        type="button"
        class="text-sm text-primary hover:text-primary/80"
    >
        + Add another time
    </button>
</div>
```

## Time Picker Features

The TimePicker includes a full-featured time selection popup with:

- Scrollable hour and minute columns
- AM/PM selector for 12-hour format
- "Now" button to select current time
- "Clear" button to reset selection
- Visual indication of selected time
- Current time display at the top
- Smooth scrolling to active selections

## Quick Actions

The time picker popup includes helpful action buttons:

- **Now** - Quickly select the current time
- **Clear** - Reset the time selection

## Keyboard Navigation

The TimePicker supports keyboard navigation:

- **Enter** - Confirm time selection
- **Escape** - Close time picker popup
- **Tab** - Move focus to next element

## Accessibility

The TimePicker component includes comprehensive accessibility features:

- Proper ARIA attributes
- Keyboard navigation support
- Screen reader friendly
- Clear visual focus states
- Semantic HTML structure
- Time picker role and ARIA labels

## Time Format Notes

### 12-Hour Format
- Displays hours 1-12
- Includes AM/PM selector
- Default placeholder: `hh:mm AM`
- Example values: `09:30 AM`, `02:15 PM`

### 24-Hour Format
- Displays hours 00-23
- No AM/PM selector
- Default placeholder: `HH:mm`
- Example values: `09:30`, `14:15`
- Input masking for proper format

## Styling

The component uses semantic design tokens from the Pegboard theme system, ensuring consistent appearance across light and dark modes. All variants and sizes automatically adapt to your theme configuration.
