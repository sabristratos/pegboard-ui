# Range Component

A powerful, accessible range slider component supporting single values and ranges (two thumbs), with smooth dragging, step snapping, custom marks, and full Livewire integration.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Modes](#modes)
  - [Single Value Mode](#single-value-mode)
  - [Range Mode (Two Thumbs)](#range-mode-two-thumbs)
- [Orientations](#orientations)
  - [Horizontal (Default)](#horizontal-default)
  - [Vertical](#vertical)
- [Features](#features)
  - [Step Snapping](#step-snapping)
  - [Custom Marks](#custom-marks)
  - [Number Formatting](#number-formatting)
  - [Visual Indicators](#visual-indicators)
  - [Hide Thumb](#hide-thumb)
  - [Visual Feedback & Interactions](#visual-feedback--interactions)
  - [Disabled State](#disabled-state)
- [Livewire Integration](#livewire-integration)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)
- [Advanced Usage](#advanced-usage)

## Overview

The Pegboard range component provides an elegant, interactive way for users to select numeric values or value ranges using a draggable slider interface. Built with Alpine.js and Tailwind CSS v4, it features smooth drag performance, precision control, and comprehensive Livewire compatibility.

**Key Features:**
- Single value or range (two thumbs) modes
- Horizontal and vertical orientations
- Precise step snapping with floating-point precision
- Custom marks and labels
- Number formatting (currency, percentages, etc.)
- Full Livewire integration with all wire:model modifiers
- Smooth 60fps drag performance via direct DOM manipulation
- Five color variants (primary, success, warning, danger, foreground)
- Three size variants (sm, md, lg)
- Optional step indicators
- Keyboard navigation (Arrow keys, Page Up/Down, Home/End)
- Full accessibility with ARIA attributes
- Rounded track styling
- **Hover effects** with subtle scale and shadow enhancements
- **Real-time tooltip** displaying formatted value during drag
- **Smooth transitions** for programmatic value changes
- **Enhanced focus indicators** with prominent ring styling
- **Disabled state** support for read-only displays

## Basic Usage

### Single Value Slider

```blade
{{-- Simple volume slider (0-100) --}}
<x-pegboard::range
    label="Volume"
    :min="0"
    :max="100"
    :value="50"
/>
```

### Range Slider (Two Thumbs)

```blade
{{-- Price range filter --}}
<x-pegboard::range
    label="Price Range"
    :min="0"
    :max="1000"
    :value="[200, 800]"
/>
```

### With Livewire

```blade
{{-- Livewire binding --}}
<x-pegboard::range
    label="Temperature"
    :min="-10"
    :max="40"
    :step="0.5"
    wire:model.live="temperature"
/>
```

## Component Structure

The range slider consists of several parts:

```
<x-pegboard::range>
    <label>                    <!-- Optional label -->
    <output>                   <!-- Optional value display -->
    <track>                    <!-- Slider track (gray background) -->
        <filler>               <!-- Filled portion (colored) -->
        <steps>                <!-- Optional step indicators -->
        <marks>                <!-- Optional custom marks -->
        <thumbs>               <!-- Draggable thumb(s) -->
            <input>            <!-- Hidden input for accessibility -->
        </thumbs>
    </track>
</x-pegboard::range>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `min` | float | `0` | Minimum value of the range |
| `max` | float | `100` | Maximum value of the range |
| `step` | float | `1` | Step increment for snapping |
| `value` | float\|array\|null | `null` | Initial value (single number or array for range mode) |
| `defaultValue` | float\|array\|null | `null` | Default value if `value` is not provided |
| `orientation` | string | `'horizontal'` | Slider orientation: `horizontal` or `vertical` |
| `size` | string | `'md'` | Size variant: `sm`, `md`, or `lg` |
| `color` | string | `'primary'` | Color variant: `primary`, `success`, `warning`, `danger`, or `foreground` |
| `label` | string\|null | `null` | Optional label text displayed above slider |
| `showValue` | bool | `true` | Whether to display current value(s) |
| `showSteps` | bool | `false` | Whether to show step indicator dots |
| `marks` | array\|null | `null` | Custom marks with labels (e.g., `[['value' => 25, 'label' => '25%']]`) |
| `hideThumb` | bool | `false` | Hide the draggable thumb (useful for display-only sliders) |
| `disabled` | bool | `false` | Disable the slider (prevents all interactions, dims appearance) |
| `formatOptions` | array\|null | `null` | Intl.NumberFormat options for value display |

### Additional Attributes

All standard HTML attributes are supported:
- `id` - Custom ID for the component
- `name` - Form field name
- `wire:model` - Livewire binding (all modifiers supported)
- `class` - Custom CSS classes (applied to wrapper)

## Modes

### Single Value Mode

Default mode when `value` is a single number:

```blade
{{-- Single value slider --}}
<x-pegboard::range
    label="Brightness"
    :min="0"
    :max="100"
    :value="75"
/>
```

**Characteristics:**
- One draggable thumb
- Filled track from start (left/bottom) to thumb position
- Value is a single number

**Use cases:**
- Volume controls
- Brightness/opacity
- Zoom levels
- Rating scales
- Age selectors

### Range Mode (Two Thumbs)

Automatically enabled when `value` is an array:

```blade
{{-- Range slider with two thumbs --}}
<x-pegboard::range
    label="Price Range"
    :min="0"
    :max="5000"
    :value="[1000, 3500]"
    :step="100"
/>
```

**Characteristics:**
- Two draggable thumbs (min and max)
- Filled track between the two thumbs
- Value is an array `[min, max]`
- Thumbs cannot cross each other

**Use cases:**
- Price range filters
- Date range selectors
- Age range filters
- Temperature ranges
- Score ranges

## Orientations

### Horizontal (Default)

Standard left-to-right slider:

```blade
<x-pegboard::range
    label="Horizontal Slider"
    :min="0"
    :max="100"
    orientation="horizontal"
/>
```

**Characteristics:**
- Thumb moves left to right
- Track fills from left
- Labels positioned above track
- Best for wide layouts

### Vertical

Bottom-to-top slider:

```blade
<x-pegboard::range
    label="Vertical Slider"
    :min="0"
    :max="100"
    orientation="vertical"
    class="h-64"
/>
```

**Characteristics:**
- Thumb moves bottom to top
- Track fills from bottom
- Labels positioned to the right
- Best for narrow/tall layouts
- **Requires height** via class (e.g., `class="h-64"`)

**Common use cases:**
- Volume controls in media players
- Vertical equalizer sliders
- Sidebar controls
- Mobile-optimized interfaces

## Features

### Step Snapping

Control precision with the `step` prop:

```blade
{{-- Integer steps --}}
<x-pegboard::range
    :min="0"
    :max="10"
    :step="1"
/>

{{-- Decimal steps --}}
<x-pegboard::range
    label="Temperature (°C)"
    :min="-10"
    :max="40"
    :step="0.5"
/>

{{-- Large steps --}}
<x-pegboard::range
    label="Budget"
    :min="0"
    :max="10000"
    :step="100"
/>
```

**How it works:**
- Values snap to nearest step increment
- Prevents floating-point precision errors
- Keyboard navigation respects steps (Arrow keys = 1 step, Page Up/Down = 10 steps)

**Step display:**
```blade
{{-- Show step indicators --}}
<x-pegboard::range
    :min="0"
    :max="100"
    :step="10"
    :showSteps="true"
/>
```

### Custom Marks

Add labeled markers at specific values:

```blade
{{-- Temperature with marks --}}
<x-pegboard::range
    label="Temperature"
    :min="0"
    :max="100"
    :step="1"
    :marks="[
        ['value' => 0, 'label' => 'Freezing'],
        ['value' => 50, 'label' => 'Comfortable'],
        ['value' => 100, 'label' => 'Boiling'],
    ]"
/>

{{-- Volume with percentage marks --}}
<x-pegboard::range
    label="Volume"
    :min="0"
    :max="100"
    :marks="[
        ['value' => 0, 'label' => '0%'],
        ['value' => 25, 'label' => '25%'],
        ['value' => 50, 'label' => '50%'],
        ['value' => 75, 'label' => '75%'],
        ['value' => 100, 'label' => '100%'],
    ]"
/>
```

**Mark positioning:**
- Horizontal: Below track, centered on value
- Vertical: Right of track, aligned with value

### Number Formatting

Use Intl.NumberFormat for automatic formatting:

```blade
{{-- Currency formatting --}}
<x-pegboard::range
    label="Price"
    :min="0"
    :max="10000"
    :step="100"
    :value="2500"
    :formatOptions="[
        'style' => 'currency',
        'currency' => 'USD',
    ]"
/>
{{-- Displays: $2,500.00 --}}

{{-- Percentage formatting --}}
<x-pegboard::range
    label="Discount"
    :min="0"
    :max="100"
    :value="25"
    :formatOptions="[
        'style' => 'percent',
        'minimumFractionDigits' => 0,
    ]"
/>
{{-- Displays: 25% --}}

{{-- Decimal places --}}
<x-pegboard::range
    label="Rating"
    :min="0"
    :max="5"
    :step="0.1"
    :value="4.5"
    :formatOptions="[
        'minimumFractionDigits' => 1,
        'maximumFractionDigits' => 1,
    ]"
/>
{{-- Displays: 4.5 --}}
```

### Visual Indicators

**Show current value:**
```blade
<x-pegboard::range
    :showValue="true"
    label="Volume"
/>
{{-- Displays value next to label --}}
```

**Hide value display:**
```blade
<x-pegboard::range
    :showValue="false"
    label="Secret Value"
/>
```

**Color variants:**
```blade
{{-- Primary (default) --}}
<x-pegboard::range color="primary" />

{{-- Success (green) --}}
<x-pegboard::range color="success" />

{{-- Warning (yellow) --}}
<x-pegboard::range color="warning" />

{{-- Danger (red) --}}
<x-pegboard::range color="danger" />

{{-- Foreground (neutral) --}}
<x-pegboard::range color="foreground" />
```

**Size variants:**
```blade
{{-- Small --}}
<x-pegboard::range size="sm" />

{{-- Medium (default) --}}
<x-pegboard::range size="md" />

{{-- Large --}}
<x-pegboard::range size="lg" />
```

### Hide Thumb

Create display-only or animated sliders:

```blade
{{-- Progress indicator (display only) --}}
<x-pegboard::range
    :min="0"
    :max="100"
    :value="$progress"
    :hideThumb="true"
    color="success"
/>

{{-- Animated loading bar --}}
<div x-data="{ progress: 0 }" x-init="setInterval(() => progress = (progress + 1) % 100, 50)">
    <x-pegboard::range
        :min="0"
        :max="100"
        ::value="progress"
        :hideThumb="true"
        :showValue="false"
    />
</div>
```

### Visual Feedback & Interactions

The range component includes rich interactive feedback for enhanced user experience:

**Hover Effects:**

When hovering over thumbs, they subtly scale up and display enhanced shadows:

```blade
<x-pegboard::range
    label="Volume"
    :min="0"
    :max="100"
/>
{{-- Thumb scales to 105% and shows larger shadow on hover --}}
```

**Real-time Dragging Tooltip:**

While dragging, a tooltip appears showing the current formatted value:

```blade
{{-- Tooltip shows "$2,545" while dragging --}}
<x-pegboard::range
    label="Price"
    :min="0"
    :max="5000"
    :step="5"
    :formatOptions="[
        'style' => 'currency',
        'currency' => 'USD',
        'minimumFractionDigits' => 0,
    ]"
/>

{{-- Tooltip shows "3.5" with decimal precision --}}
<x-pegboard::range
    label="Rating"
    :min="0"
    :max="5"
    :step="0.1"
    :formatOptions="[
        'minimumFractionDigits' => 1,
        'maximumFractionDigits' => 1,
    ]"
/>
```

The tooltip:
- Appears automatically when dragging starts
- Updates in real-time as you drag
- Positioned above (horizontal) or beside (vertical) the thumb
- Respects `formatOptions` for consistent formatting
- Fades out smoothly when drag ends

**Smooth Programmatic Transitions:**

When values change from Livewire or external updates, the thumb animates smoothly to its new position:

```blade
{{-- Thumb animates smoothly when $volume changes --}}
<x-pegboard::range
    wire:model.live="volume"
    :min="0"
    :max="100"
/>

{{-- Transitions disabled during manual drag for 60fps performance --}}
```

**Enhanced Focus Indicators:**

When navigating with the keyboard (Tab key), thumbs display a prominent focus ring:

```blade
<x-pegboard::range
    label="Accessible Slider"
    :min="0"
    :max="100"
/>
{{-- Press Tab to focus, use Arrow keys to adjust --}}
{{-- 4px primary-colored ring with 2px offset for visibility --}}
```

Focus indicators:
- Only appear on keyboard focus (not mouse clicks)
- Meet WCAG AA contrast requirements
- 4px ring with primary color at 30% opacity
- Smooth transitions between states

### Disabled State

Disable sliders to prevent interaction while maintaining visual context:

```blade
{{-- Disabled slider (read-only) --}}
<x-pegboard::range
    label="System Setting"
    :min="0"
    :max="100"
    :value="75"
    :disabled="true"
/>

{{-- Conditionally disabled --}}
<x-pegboard::range
    label="Premium Feature"
    :min="0"
    :max="100"
    :disabled="!$user->isPremium()"
/>

{{-- Disabled during loading --}}
<x-pegboard::range
    label="Processing..."
    :min="0"
    :max="100"
    :value="$currentValue"
    :disabled="$isLoading"
    wire:loading.attr="disabled"
/>
```

**Disabled appearance:**
- 60% opacity (dims the entire component)
- Pointer events disabled (no hover, drag, or click)
- `aria-disabled="true"` for screen readers
- Value still visible for context

**Use cases:**
- Settings that require permissions
- Read-only configuration displays
- Loading states during async operations
- Temporarily locked controls
- Display-only progress indicators

## Livewire Integration

The range component has **full Livewire compatibility** with all wire:model modifiers.

### Basic Binding

```blade
{{-- Live updates (default behavior) --}}
<x-pegboard::range
    label="Volume"
    :min="0"
    :max="100"
    wire:model.live="volume"
/>

{{-- Deferred updates (on blur) --}}
<x-pegboard::range
    label="Price"
    :min="0"
    :max="1000"
    wire:model.blur="price"
/>

{{-- On change (when drag ends) --}}
<x-pegboard::range
    label="Temperature"
    :min="0"
    :max="100"
    wire:model="temperature"
/>
```

### Livewire Component Example

```php
namespace App\Livewire;

use Livewire\Component;

class ProductFilter extends Component
{
    public int $minPrice = 0;
    public int $maxPrice = 1000;
    public array $priceRange = [0, 1000];

    public function render()
    {
        return view('livewire.product-filter');
    }
}
```

```blade
{{-- livewire/product-filter.blade.php --}}
<div>
    {{-- Range mode with Livewire --}}
    <x-pegboard::range
        label="Price Range"
        :min="0"
        :max="1000"
        :step="10"
        wire:model.live="priceRange"
    />

    <p>Min: ${{ $priceRange[0] }} - Max: ${{ $priceRange[1] }}</p>
</div>
```

### How It Works

**During drag:**
- Values update locally (smooth 60fps performance)
- NO Livewire sync during drag (prevents blocking)

**When drag ends:**
- Final value syncs to Livewire
- Component re-renders with server state

**Benefits:**
- ✅ Smooth drag experience
- ✅ No lag or stuttering
- ✅ Works with wire:model.live, .defer, .blur
- ✅ Server-side validation supported

## Examples

### Volume Control

```blade
<x-pegboard::range
    label="Volume"
    :min="0"
    :max="100"
    :value="75"
    :step="1"
    :showSteps="true"
    color="primary"
/>
```

### Price Range Filter

```blade
<x-pegboard::range
    label="Price Range"
    :min="0"
    :max="5000"
    :value="[500, 3000]"
    :step="100"
    wire:model.live="priceRange"
    :formatOptions="[
        'style' => 'currency',
        'currency' => 'USD',
        'minimumFractionDigits' => 0,
    ]"
/>
```

### Temperature Selector

```blade
<x-pegboard::range
    label="Temperature (°C)"
    :min="-20"
    :max="50"
    :step="0.5"
    :value="22"
    color="warning"
    :marks="[
        ['value' => -20, 'label' => 'Cold'],
        ['value' => 0, 'label' => 'Freezing'],
        ['value' => 22, 'label' => 'Room Temp'],
        ['value' => 50, 'label' => 'Hot'],
    ]"
/>
```

### Opacity Control (Vertical)

```blade
<div class="flex gap-4">
    <x-pegboard::range
        label="Opacity"
        :min="0"
        :max="100"
        :value="100"
        orientation="vertical"
        class="h-48"
    />

    <div class="w-32 h-48 bg-primary" :style="`opacity: ${opacity / 100}`"></div>
</div>
```

### Age Range Filter

```blade
<x-pegboard::range
    label="Age Range"
    :min="18"
    :max="100"
    :value="[25, 65]"
    :step="1"
    wire:model.live="ageRange"
/>
```

### Rating Input

```blade
<x-pegboard::range
    label="Your Rating"
    :min="0"
    :max="5"
    :step="0.5"
    :value="4.5"
    color="warning"
    :formatOptions="[
        'minimumFractionDigits' => 1,
        'maximumFractionDigits' => 1,
    ]"
    :marks="[
        ['value' => 0, 'label' => '☆'],
        ['value' => 1, 'label' => '★'],
        ['value' => 2, 'label' => '★★'],
        ['value' => 3, 'label' => '★★★'],
        ['value' => 4, 'label' => '★★★★'],
        ['value' => 5, 'label' => '★★★★★'],
    ]"
/>
```

### Zoom Control

```blade
<x-pegboard::range
    label="Zoom"
    :min="25"
    :max="400"
    :value="100"
    :step="25"
    :showSteps="true"
    :marks="[
        ['value' => 25, 'label' => '25%'],
        ['value' => 100, 'label' => '100%'],
        ['value' => 400, 'label' => '400%'],
    ]"
/>
```

### Progress Indicator (Read-Only)

```blade
<x-pegboard::range
    label="Upload Progress"
    :min="0"
    :max="100"
    :value="$uploadProgress"
    :hideThumb="true"
    :showValue="true"
    :disabled="true"
    color="success"
/>
```

## Best Practices

### 1. Choose Appropriate Step Values

```blade
{{-- ✅ Good - Integer steps for whole numbers --}}
<x-pegboard::range :min="0" :max="10" :step="1" />

{{-- ✅ Good - Decimal steps for precision --}}
<x-pegboard::range :min="0" :max="5" :step="0.1" />

{{-- ❌ Bad - Step too small for range --}}
<x-pegboard::range :min="0" :max="10000" :step="1" />
{{-- Better: use :step="100" --}}
```

### 2. Provide Context with Labels and Marks

```blade
{{-- ✅ Good - Clear labels --}}
<x-pegboard::range
    label="Volume (dB)"
    :marks="[
        ['value' => 0, 'label' => 'Muted'],
        ['value' => 100, 'label' => 'Max'],
    ]"
/>

{{-- ❌ Bad - No context --}}
<x-pegboard::range :min="0" :max="100" />
```

### 3. Format Values Appropriately

```blade
{{-- ✅ Good - Currency formatting for prices --}}
<x-pegboard::range
    label="Budget"
    :formatOptions="['style' => 'currency', 'currency' => 'USD']"
/>

{{-- ❌ Bad - Raw numbers for currency --}}
<x-pegboard::range label="Budget ($)" />
```

### 4. Use Vertical Orientation Wisely

```blade
{{-- ✅ Good - Vertical for narrow spaces --}}
<div class="w-16">
    <x-pegboard::range orientation="vertical" class="h-48" />
</div>

{{-- ❌ Bad - Vertical without height --}}
<x-pegboard::range orientation="vertical" />
{{-- Component will collapse! --}}
```

### 5. Choose Range vs Single Mode Based on Use Case

**Use Range Mode when:**
- User needs to select a range (price filter, date range, etc.)
- Both min and max boundaries are important
- Filtering data within a range

**Use Single Mode when:**
- User selects one specific value
- Controlling settings (volume, brightness, etc.)
- Selecting from a scale (ratings, zoom, etc.)

### 6. Match Color to Semantic Meaning

```blade
{{-- ✅ Good - Success for positive metrics --}}
<x-pegboard::range label="Health" color="success" />

{{-- ✅ Good - Danger for critical values --}}
<x-pegboard::range label="Temperature Alert" color="danger" />

{{-- ❌ Bad - Misleading color --}}
<x-pegboard::range label="Error Rate" color="success" />
```

### 7. Consider Mobile Users

```blade
{{-- ✅ Good - Larger size for mobile --}}
<x-pegboard::range
    size="lg"
    class="sm:size-md"
/>

{{-- ✅ Good - Adequate step size for touch --}}
<x-pegboard::range :step="10" />
{{-- Easier to drag on mobile than :step="1" --}}
```

### 8. Use showSteps Sparingly

```blade
{{-- ✅ Good - Steps visible for small ranges --}}
<x-pegboard::range :min="0" :max="10" :showSteps="true" />

{{-- ❌ Bad - Too many steps (cluttered) --}}
<x-pegboard::range :min="0" :max="100" :step="1" :showSteps="true" />
```

**Note:** Step indicators are automatically hidden if there are more than 100 steps.

## Accessibility

The range component follows WCAG 2.1 guidelines and provides full keyboard accessibility.

### ARIA Attributes

Automatically included:
- `role="group"` on wrapper
- `role="slider"` on each thumb
- `aria-label` describes each thumb
- `aria-valuemin`, `aria-valuemax`, `aria-valuenow` on thumbs
- `aria-live="off"` on output (prevents announcement spam)
- `aria-disabled="true"` when `disabled` prop is true

### Keyboard Navigation

**Arrow Keys:**
- `←` / `↓` - Decrease by one step
- `→` / `↑` - Increase by one step

**Page Keys:**
- `Page Down` - Decrease by 10 steps
- `Page Up` - Increase by 10 steps

**Home/End:**
- `Home` - Jump to minimum value (or other thumb in range mode)
- `End` - Jump to maximum value (or other thumb in range mode)

**Focus Management:**
- Thumbs are keyboard focusable (`tabindex="0"`)
- **Enhanced focus ring** with 4px primary-colored border and 2px offset
- Only visible on keyboard focus (`:focus-visible`), not mouse clicks
- Smooth transitions between focus states
- Focus persists during drag operations

### Screen Reader Support

```blade
{{-- Screen reader announces: --}}
{{-- "Volume slider, 75 out of 100" --}}
<x-pegboard::range
    label="Volume"
    :min="0"
    :max="100"
    :value="75"
/>

{{-- Range mode announces both thumbs: --}}
{{-- "Price Range slider, Thumb 1: 200 out of 1000" --}}
{{-- "Price Range slider, Thumb 2: 800 out of 1000" --}}
<x-pegboard::range
    label="Price Range"
    :min="0"
    :max="1000"
    :value="[200, 800]"
/>
```

### Color Contrast

All color variants meet WCAG AA standards:
- Track background: Sufficient contrast with page background
- Filled track: 3:1 minimum contrast ratio
- Thumb: 4.5:1 contrast ratio
- Focus ring: 3:1 contrast ratio

### Best Practices for Accessibility

**1. Always provide labels:**
```blade
{{-- ✅ Good --}}
<x-pegboard::range label="Volume" />

{{-- ❌ Bad --}}
<x-pegboard::range />
```

**2. Use meaningful step values:**
```blade
{{-- ✅ Good - Logical steps --}}
<x-pegboard::range :step="10" />

{{-- ❌ Bad - Tiny steps (hard for keyboard users) --}}
<x-pegboard::range :step="0.001" />
```

**3. Provide visual feedback:**
```blade
{{-- ✅ Good - Shows current value --}}
<x-pegboard::range :showValue="true" />

{{-- ❌ Bad - No feedback --}}
<x-pegboard::range :showValue="false" :hideThumb="true" />
```

## Advanced Usage

### Custom Styling

```blade
{{-- Add custom classes to wrapper --}}
<x-pegboard::range
    class="my-custom-class p-4 bg-gray-100 rounded-lg"
/>

{{-- Combine with Tailwind utilities --}}
<x-pegboard::range
    class="w-full max-w-md mx-auto"
/>
```

### Conditional Rendering

```blade
{{-- Show different sliders based on condition --}}
@if($userType === 'premium')
    <x-pegboard::range
        label="Quality"
        :min="0"
        :max="100"
        :step="1"
        color="success"
    />
@else
    <x-pegboard::range
        label="Quality (Limited)"
        :min="0"
        :max="50"
        :step="5"
        color="warning"
    />
@endif
```

### Named Slots (Start/End Content)

Add icons or buttons before/after the track:

```blade
<x-pegboard::range label="Volume">
    <x-slot:startContent>
        <x-pegboard::icon name="speaker-x-mark" class="w-4 h-4 text-muted-foreground" />
    </x-slot:startContent>

    <x-slot:endContent>
        <x-pegboard::icon name="speaker-wave" class="w-4 h-4 text-muted-foreground" />
    </x-slot:endContent>
</x-pegboard::range>
```

### Dynamic Values with Alpine

```blade
<div x-data="{ volume: 50 }">
    <x-pegboard::range
        label="Volume"
        :min="0"
        :max="100"
        ::value="volume"
        @change="volume = $event.target.value"
    />

    <p x-text="`Current volume: ${volume}%`"></p>
</div>
```

### Integration with Forms

```blade
<form method="POST" action="/save-settings">
    @csrf

    <x-pegboard::range
        name="volume"
        label="Volume"
        :min="0"
        :max="100"
        :value="old('volume', $settings->volume)"
    />

    <x-pegboard::range
        name="price_range[]"
        label="Price Range"
        :min="0"
        :max="1000"
        :value="old('price_range', [100, 500])"
    />

    <button type="submit">Save Settings</button>
</form>
```

---

## Performance Notes

The range component uses **direct DOM manipulation during drag** for optimal performance:

- **60fps** smooth dragging
- **No Alpine reactivity** during drag (prevents lag)
- **No Livewire sync** during drag (prevents blocking)
- Final value committed when drag ends

This architecture ensures the slider feels native and responsive, even with complex Livewire applications.

## Browser Support

- Chrome/Edge: Full support
- Firefox: Full support
- Safari: Full support
- Mobile browsers: Full touch support

## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
- [ARIA: slider role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/slider_role)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
