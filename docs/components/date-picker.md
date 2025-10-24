# DatePicker Component

A flexible date picker with calendar popup, validation states, range selection, and full Livewire compatibility.

## Basic Usage

```blade
<x-pegboard::date-picker placeholder="Select date..." />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Visual variant: `'default'`, `'error'`, `'success'` |
| `size` | string | `'md'` | Size variant: `'xs'`, `'sm'`, `'md'`, `'lg'` |
| `format` | string | `'Y-m-d'` | Date format (PHP date format string) |
| `value` | string\|null | `null` | Initial selected date value |
| `placeholder` | string | `'Select date'` | Placeholder text |
| `name` | string\|null | `null` | Form field name |
| `range` | bool | `false` | Enable date range selection |
| `clearable` | bool | `false` | Shows a clear button when date is selected |
| `disabled` | bool | `false` | Disables the date picker |

## Variants

DatePickers support three validation variants for visual feedback:

```blade
<!-- Default state -->
<x-pegboard::date-picker variant="default" placeholder="Select date..." />

<!-- Error state -->
<x-pegboard::date-picker variant="error" placeholder="Required field" />
<p class="text-sm text-destructive mt-1">Date is required</p>

<!-- Success state -->
<x-pegboard::date-picker variant="success" value="2025-01-15" />
<p class="text-sm text-success mt-1">Valid date selected</p>
```

## Sizes

Four size options are available to match your design:

```blade
<!-- Extra Small -->
<x-pegboard::date-picker size="xs" placeholder="XS Date" />

<!-- Small -->
<x-pegboard::date-picker size="sm" placeholder="SM Date" />

<!-- Medium (Default) -->
<x-pegboard::date-picker size="md" placeholder="MD Date" />

<!-- Large -->
<x-pegboard::date-picker size="lg" placeholder="LG Date" />
```

## Date Formats

Customize the date format using PHP date format strings:

```blade
<!-- Default format: Y-m-d (2025-01-15) -->
<x-pegboard::date-picker format="Y-m-d" />

<!-- US format: m/d/Y (01/15/2025) -->
<x-pegboard::date-picker format="m/d/Y" placeholder="MM/DD/YYYY" />

<!-- European format: d/m/Y (15/01/2025) -->
<x-pegboard::date-picker format="d/m/Y" placeholder="DD/MM/YYYY" />

<!-- Long format: F j, Y (January 15, 2025) -->
<x-pegboard::date-picker format="F j, Y" placeholder="Month Day, Year" />
```

## Range Selection

Enable date range selection for selecting start and end dates:

```blade
<x-pegboard::date-picker
    range
    placeholder="Select date range..."
    name="date_range"
/>
```

When using range selection, the value will contain both start and end dates.

## Clearable

Add a clear button that appears when a date is selected:

```blade
<x-pegboard::date-picker
    clearable
    value="2025-01-15"
    placeholder="Select date..."
/>
```

## Disabled State

Disable the date picker to make it read-only:

```blade
<!-- Disabled empty -->
<x-pegboard::date-picker disabled placeholder="Cannot select..." />

<!-- Disabled with value -->
<x-pegboard::date-picker disabled value="2025-01-15" />

<!-- Disabled with validation state -->
<x-pegboard::date-picker disabled variant="error" value="2025-01-15" />
```

## Form Submission

The DatePicker component works with traditional form submissions and Livewire:

### Traditional Forms

```blade
<form action="/submit" method="POST">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-2">Event Date</label>
        <x-pegboard::date-picker
            name="event_date"
            placeholder="Select event date..."
        />
    </div>

    <button type="submit">Submit</button>
</form>
```

### Livewire Integration

```blade
<!-- Two-way binding -->
<x-pegboard::date-picker
    wire:model="eventDate"
    placeholder="Select event date..."
/>

<!-- Live binding -->
<x-pegboard::date-picker
    wire:model.live="startDate"
    placeholder="Start date..."
/>

<!-- Blur binding -->
<x-pegboard::date-picker
    wire:model.blur="endDate"
    placeholder="End date..."
/>
```

## Real-World Examples

### Event Registration Form

```blade
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium mb-2">Event Date</label>
        <x-pegboard::date-picker
            wire:model="form.event_date"
            variant="{{ $errors->has('form.event_date') ? 'error' : 'default' }}"
            clearable
            placeholder="Select event date..."
        />
        @error('form.event_date')
            <p class="text-sm text-destructive mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
```

### Date Range Filter

```blade
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-2">Start Date</label>
        <x-pegboard::date-picker
            wire:model.live="filters.start_date"
            clearable
            placeholder="From..."
        />
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">End Date</label>
        <x-pegboard::date-picker
            wire:model.live="filters.end_date"
            clearable
            placeholder="To..."
        />
    </div>
</div>
```

### Birthday Selection

```blade
<div>
    <label class="block text-sm font-medium mb-2">Date of Birth</label>
    <x-pegboard::date-picker
        name="date_of_birth"
        format="m/d/Y"
        clearable
        placeholder="MM/DD/YYYY"
        variant="{{ $errors->has('date_of_birth') ? 'error' : 'success' }}"
    />
</div>
```

### Appointment Scheduler

```blade
<div class="max-w-md">
    <label class="block text-sm font-medium mb-2">Appointment Date</label>
    <x-pegboard::date-picker
        wire:model.live="appointment.date"
        size="lg"
        clearable
        placeholder="Select appointment date..."
    />

    @if($appointment->date)
        <p class="text-sm text-muted-foreground mt-2">
            Selected: {{ $appointment->date->format('l, F j, Y') }}
        </p>
    @endif
</div>
```

## Calendar Features

The DatePicker includes a full-featured calendar popup with:

- Month and year navigation
- Keyboard navigation support
- Click to select dates
- Visual indication of selected date
- Today's date highlighting
- Disabled dates support (via JavaScript API)

## Keyboard Navigation

The DatePicker supports keyboard navigation:

- **Enter** - Confirm date selection
- **Escape** - Close calendar popup
- **Arrow keys** - Navigate through calendar (when popup is open)
- **Tab** - Move focus to next element

## Accessibility

The DatePicker component includes comprehensive accessibility features:

- Proper ARIA attributes
- Keyboard navigation support
- Screen reader friendly
- Clear visual focus states
- Semantic HTML structure
- Calendar role and ARIA labels

## Styling

The component uses semantic design tokens from the Pegboard theme system, ensuring consistent appearance across light and dark modes. All variants and sizes automatically adapt to your theme configuration.
