# Button Component

A versatile button component with multiple variants, sizes, and states including loading indicators and icon support.

## Features

- 5 visual variants (primary, secondary, destructive, outline, ghost)
- 3 sizes (xs, sm, md)
- Icon support (left and/or right)
- Loading state with auto-disable
- Custom icon variants (micro, mini, outline, solid)

## Basic Usage

```blade
{{-- Simple button --}}
<x-pegboard::button>Click me</x-pegboard::button>

{{-- With variant --}}
<x-pegboard::button variant="secondary">Secondary</x-pegboard::button>
<x-pegboard::button variant="destructive">Delete</x-pegboard::button>
<x-pegboard::button variant="outline">Outline</x-pegboard::button>
<x-pegboard::button variant="ghost">Ghost</x-pegboard::button>

{{-- Different sizes --}}
<x-pegboard::button size="xs">Extra Small</x-pegboard::button>
<x-pegboard::button size="sm">Small</x-pegboard::button>
<x-pegboard::button size="md">Medium</x-pegboard::button>

{{-- With icons --}}
<x-pegboard::button icon="plus">Add Item</x-pegboard::button>
<x-pegboard::button icon-right="arrow-right">Next</x-pegboard::button>
<x-pegboard::button icon="save" icon-right="arrow-down">Save & Continue</x-pegboard::button>

{{-- Icon only (auto-detects and applies square aspect ratio) --}}
<x-pegboard::button icon="pencil" />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'primary'` | Visual variant: `primary`, `secondary`, `destructive`, `outline`, `ghost` |
| `size` | string | `'md'` | Size: `xs`, `sm`, `md` |
| `icon` | string\|null | `null` | Icon name for left side |
| `iconRight` | string\|null | `null` | Icon name for right side |
| `iconVariant` | string\|null | `null` | Icon variant: `micro`, `mini`, `outline`, `solid` (auto-selected based on size if null) |
| `loading` | bool | `false` | Show loading spinner and disable button |

## Variants

### Primary
Default variant with solid primary color background:
```blade
<x-pegboard::button variant="primary">Primary Action</x-pegboard::button>
```

### Secondary
Neutral gray background for secondary actions:
```blade
<x-pegboard::button variant="secondary">Cancel</x-pegboard::button>
```

### Destructive
Red theme for destructive actions:
```blade
<x-pegboard::button variant="destructive">Delete</x-pegboard::button>
```

### Outline
Bordered button with transparent background:
```blade
<x-pegboard::button variant="outline">View Details</x-pegboard::button>
```

### Ghost
Minimal button with no background until hover:
```blade
<x-pegboard::button variant="ghost">Learn More</x-pegboard::button>
```

## Loading State

The loading state replaces button content with a spinner and "Loading..." text, and automatically disables the button:

```blade
{{-- PHP-driven loading state --}}
<x-pegboard::button :loading="true">Save</x-pegboard::button>

{{-- With Livewire wire:loading --}}
<div x-data="{ loading: false }" wire:loading.delay="loading = true" wire:target="save">
    <x-pegboard::button ::loading="loading" wire:click="save">Save</x-pegboard::button>
</div>

{{-- Alpine.js-driven loading state --}}
<div x-data="{ submitting: false }">
    <x-pegboard::button
        ::loading="submitting"
        @click="submitting = true; await saveForm(); submitting = false"
    >
        Submit Form
    </x-pegboard::button>
</div>
```

**Loading State Features:**
- Replaces all button content with spinner + "Loading..." text
- Automatically adds `disabled` and `aria-busy="true"` attributes
- Applies opacity and cursor styles (60% opacity, not-allowed cursor)
- Spinner matches button icon sizes (h-3 w-3 for xs, h-3.5 w-3.5 for sm, h-4 w-4 for md)
- Spinner uses `currentColor` to inherit button text color

## Icon Support

### Icon Sizing
Icons automatically scale based on button size:

```blade
{{-- Extra small button: h-3 w-3 icons --}}
<x-pegboard::button size="xs" icon="check">Save</x-pegboard::button>

{{-- Small button: h-3.5 w-3.5 icons --}}
<x-pegboard::button size="sm" icon="check">Save</x-pegboard::button>

{{-- Medium button: h-4 w-4 icons --}}
<x-pegboard::button size="md" icon="check">Save</x-pegboard::button>
```

### Icon Variants
Icon variant defaults to `micro` for xs size, `mini` for sm and md. Override with `iconVariant`:

```blade
<x-pegboard::button icon="star" icon-variant="solid">Featured</x-pegboard::button>
<x-pegboard::button icon="heart" icon-variant="outline">Like</x-pegboard::button>
```

### Icon-Only Buttons
When a button has an icon but no visible text content, it automatically becomes square:

```blade
{{-- These automatically get aspect-square styling --}}
<x-pegboard::button icon="pencil" />
<x-pegboard::button icon="trash" variant="destructive" />
<x-pegboard::button icon="cog" size="sm" />
```

## Button Groups

Buttons work seamlessly in button groups:

```blade
<div data-slot="button-group" class="inline-flex">
    <x-pegboard::button>First</x-pegboard::button>
    <x-pegboard::button>Second</x-pegboard::button>
    <x-pegboard::button>Third</x-pegboard::button>
</div>
```

## Customization

Pass custom classes that merge with base styles:

```blade
{{-- Add margins --}}
<x-pegboard::button class="mx-4 my-2">Custom Spacing</x-pegboard::button>

{{-- Custom width --}}
<x-pegboard::button class="w-full">Full Width</x-pegboard::button>

{{-- Additional effects --}}
<x-pegboard::button variant="primary" class="shadow-xl hover:scale-105">
    Enhanced Button
</x-pegboard::button>
```

## Accessibility

- Uses semantic `<button>` element
- Default `type="button"` (override with `type="submit"` when needed)
- Loading state adds `disabled` and `aria-busy="true"` attributes
- Icon-only buttons should include `aria-label`:
  ```blade
  <x-pegboard::button icon="pencil" aria-label="Edit item" />
  ```
- Focus visible ring with offset for keyboard navigation
- Works without JavaScript (except loading state interactivity)
