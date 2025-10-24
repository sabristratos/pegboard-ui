# Input Component

A flexible input component with icon support, action buttons, and built-in features like clear, copy, password toggle, and loading states.

## Features

- 2 sizes (sm, md)
- Icon support (left and/or right)
- Custom icon variants (micro, mini, outline, solid)
- Clearable input with X button
- Password visibility toggle
- Copy to clipboard functionality
- View URL in new page button
- Loading state with spinner
- Custom actions slot for additional buttons
- Alpine.js + Livewire compatible (no x-model conflicts)
- Data attribute-driven styling

## Basic Usage

```blade
{{-- Simple input --}}
<x-pegboard::input placeholder="Enter your name" />

{{-- With icons --}}
<x-pegboard::input icon="envelope" placeholder="Email address" />
<x-pegboard::input icon-right="arrow-right" placeholder="Search" />

{{-- Different sizes --}}
<x-pegboard::input size="sm" placeholder="Small input" />
<x-pegboard::input size="md" placeholder="Medium input" />

{{-- With wire:model (Livewire) --}}
<x-pegboard::input wire:model.live="email" placeholder="Email" />

{{-- With attributes --}}
<x-pegboard::input
    type="email"
    name="email"
    required
    placeholder="Required email"
/>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `'md'` | Size: `sm`, `md` |
| `icon` | string\|null | `null` | Icon name for left side |
| `iconRight` | string\|null | `null` | Icon name for right side |
| `iconVariant` | string\|null | `null` | Icon variant: `micro`, `mini`, `outline`, `solid` (defaults to `outline`) |
| `clearable` | bool | `false` | Show clear button (X icon) when input has value |
| `showPassword` | bool | `false` | Show password visibility toggle button |
| `copy` | bool | `false` | Show copy to clipboard button |
| `viewInNewPage` | bool | `false` | Show "open in new tab" button for URLs |
| `loading` | bool | `false` | Show loading spinner and disable input |

## Built-in Features

### Clearable Input

Show a clear button that appears when input has value:

```blade
<x-pegboard::input :clearable="true" placeholder="Type to see clear button" />
```

**Behavior:**
- Clear button shows only when input has value (using Alpine.js `x-show="$refs.input.value"`)
- Clicking clear button empties the input and dispatches an `input` event for Livewire compatibility
- Works with both Alpine.js and Livewire `wire:model`

### Password Toggle

Toggle password visibility for password fields:

```blade
<x-pegboard::input
    type="password"
    :show-password="true"
    placeholder="Enter password"
/>
```

**Behavior:**
- Shows eye icon when password is hidden
- Shows eye-slash icon when password is visible
- Toggles input type between `password` and `text`
- Works seamlessly with password managers

### Copy to Clipboard

Copy input value to clipboard with visual feedback:

```blade
<x-pegboard::input
    :copy="true"
    value="Text to copy"
    placeholder="Copy this text"
/>
```

**Behavior:**
- Shows clipboard icon by default
- Shows check icon for 2 seconds after successful copy
- Updates aria-label from "Copy to clipboard" to "Copied!"
- Uses Clipboard API for modern browsers

### View in New Page

Open input URL in a new tab (useful for URL fields):

```blade
<x-pegboard::input
    :view-in-new-page="true"
    placeholder="https://example.com"
/>
```

**Behavior:**
- Button only appears when input has a valid URL
- Opens link in new tab with `target="_blank"` and `rel="noopener noreferrer"`
- Validates URL format before showing button

### Loading State

Show loading spinner and disable input:

```blade
{{-- PHP-driven loading state --}}
<x-pegboard::input :loading="true" placeholder="Loading..." />

{{-- With Livewire wire:loading --}}
<x-pegboard::input
    wire:model.live="searchQuery"
    wire:loading.delay.attr="loading"
    wire:target="searchQuery"
    placeholder="Search..."
/>
```

**Loading State Features:**
- Shows spinner before other action buttons
- Automatically disables input
- Adds `aria-busy="true"` for accessibility
- Spinner matches input size (sm uses smaller spinner)

## Icon Support

### Icon Positioning

```blade
{{-- Left icon --}}
<x-pegboard::input icon="magnifying-glass" placeholder="Search" />

{{-- Right icon --}}
<x-pegboard::input icon-right="arrow-right" placeholder="Enter to submit" />

{{-- Both sides --}}
<x-pegboard::input
    icon="lock"
    icon-right="check"
    placeholder="Secure input"
/>
```

### Icon Variants

```blade
{{-- Default: outline variant --}}
<x-pegboard::input icon="star" />

{{-- Solid variant --}}
<x-pegboard::input icon="star" icon-variant="solid" />

{{-- Micro variant --}}
<x-pegboard::input icon="star" icon-variant="micro" />
```

## Custom Actions Slot

Add custom action buttons using the `actions` slot:

```blade
<x-pegboard::input placeholder="Custom actions">
    <x-slot:actions>
        <button
            type="button"
            class="flex items-center text-muted-foreground hover:text-foreground"
            @click="alert('Custom action!')"
        >
            <x-pegboard::icon name="sparkles" class="h-4 w-4" />
        </button>
    </x-slot:actions>
</x-pegboard::input>
```

**Action Button Order:**
1. Loading spinner (if `loading="true"`)
2. Custom actions from slot
3. Right icon (if `icon-right` prop provided)
4. Clear button (if `clearable="true"` and input has value)
5. Password toggle (if `show-password="true"`)
6. Copy button (if `copy="true"`)
7. View in new page (if `view-in-new-page="true"` and valid URL)

## Alpine.js + Livewire Compatibility

**CRITICAL: The component avoids x-model to prevent conflicts with Livewire wire:model.**

The input component uses Alpine.js but reads/writes values directly from the DOM element:

```typescript
// Alpine.js component definition (simplified)
Alpine.data('pegboardInput', () => ({
    // No 'value' property - reads from DOM directly

    clear() {
        const input = this.$refs.input;
        input.value = '';
        // Dispatch event for Livewire compatibility
        input.dispatchEvent(new Event('input', { bubbles: true }));
    }
}));
```

**Why this works:**
- Without `wire:model`: Input works as normal HTML, Alpine enhances it
- With `wire:model`: Livewire binds the input, Alpine reads the Livewire-controlled value from DOM
- Actions always work: Alpine methods read/write to the DOM element directly
- Events propagate: Native `input` events ensure Livewire picks up changes

**Usage examples:**

```blade
{{-- Works perfectly with Livewire wire:model --}}
<x-pegboard::input
    wire:model.live="email"
    :clearable="true"
    placeholder="Email"
/>

{{-- Works without Livewire too --}}
<x-pegboard::input
    name="email"
    :clearable="true"
    placeholder="Email"
/>
```

## Data Attribute Architecture

The Input component uses data attributes for CSS targeting and JavaScript:

```blade
<div data-pegboard-group-item data-pegboard-control>
    {{-- Wrapper div with focus ring, border, etc. --}}
    <input x-ref="input" />
</div>
```

**Data Attributes:**
- `data-pegboard-group-item` - Identifies component for layout purposes
- `data-pegboard-control` - Identifies as a form control for styling/targeting

**Benefits:**
- CSS can target specific elements (e.g., `.form-group [data-pegboard-control]`)
- JavaScript can select all form controls
- Consistent with Pegboard architecture

## Attribute Behavior

**Important:** The `class` attribute applies to the **wrapper div**, not the input element:

```blade
{{-- This adds classes to the wrapper (border, focus ring) --}}
<x-pegboard::input class="w-full max-w-md" />

{{-- To style the actual input element, use data attributes --}}
<style>
  [data-pegboard-control] input {
    /* Custom input styles */
  }
</style>
```

**Attributes that apply to the input element:**
- `type`, `name`, `value`, `placeholder`
- `required`, `disabled`, `readonly`
- `wire:model`, `wire:model.live`, etc.
- All standard HTML input attributes

**Attributes filtered to wrapper only:**
- `class` (applies to wrapper)
- `clearable`, `showPassword`, `copy`, `viewInNewPage` (handled by component)

## Sizing System

Input sizing uses PHP match expressions:

```php
// Wrapper padding/text size
$sizeClasses = match($size) {
    'sm' => 'px-2 text-sm',
    default => 'px-3 text-base',
};

// Input padding (vertical only)
$inputSizeClasses = match($size) {
    'sm' => 'py-1',
    default => 'py-1.5',
};

// Icon size
$iconSize = match($size) {
    'sm' => 'h-3.5 w-3.5',
    default => 'h-4 w-4',
};
```

## Customization

Pass custom classes that merge with base styles:

```blade
{{-- Custom width --}}
<x-pegboard::input class="w-full max-w-lg" />

{{-- Custom spacing --}}
<x-pegboard::input class="my-4" />

{{-- Override border/shadow --}}
<x-pegboard::input class="!border-2 !border-primary !shadow-lg" />
```

## Accessibility

- Uses semantic `<input>` element
- Action buttons include proper `aria-label` attributes
- Loading state adds `disabled` and `aria-busy="true"` attributes
- Focus visible ring with offset for keyboard navigation
- Icons are decorative (text/placeholder provides context)
- Copy button updates aria-label on success
- Works without JavaScript (except action buttons)
