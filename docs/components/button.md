# Button Component

A versatile button component with multiple variants, sizes, states, and icon support. Built with Tailwind CSS v4 and optimized for both standalone use and Livewire integration.

## Features

- ✅ Six distinct visual variants (primary, secondary, success, destructive, outline, ghost)
- ✅ Four sizes (xs, sm, md, lg)
- ✅ Left and right icon support
- ✅ Icon-only mode with perfect square aspect ratio
- ✅ Loading states with custom text
- ✅ Disabled state
- ✅ Button group support
- ✅ Full TypeScript definitions
- ✅ Accessible (ARIA attributes, keyboard navigation)
- ✅ Theme-aware (uses semantic design tokens)

---

## Basic Usage

```blade
<x-pegboard::button>Click me</x-pegboard::button>
```

---

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'primary'` | Visual style variant: `primary`, `secondary`, `success`, `destructive`, `outline`, `ghost` |
| `size` | `string` | `'md'` | Button size: `xs`, `sm`, `md`, `lg` |
| `icon` | `string` | `null` | Heroicon name to display on the left |
| `iconRight` | `string` | `null` | Heroicon name to display on the right |
| `iconVariant` | `string` | Auto | Icon variant: `mini`, `micro`, `outline`, `solid` (auto-selected based on size) |
| `loading` | `bool` | `false` | Show loading spinner and disable button |
| `loadingText` | `string` | `'Loading...'` | Custom text to display during loading state |
| `disabled` | `bool` | `false` | Disable the button |
| `iconOnly` | `bool` | `false` | Explicitly mark button as icon-only (affects sizing) |

All standard HTML button attributes are supported via `$attributes` (e.g., `type`, `wire:click`, `class`, etc.).

---

## Variants

### Primary (Default)
Used for primary actions and CTAs.

```blade
<x-pegboard::button variant="primary">Save Changes</x-pegboard::button>
```

### Secondary
Used for secondary actions.

```blade
<x-pegboard::button variant="secondary">Cancel</x-pegboard::button>
```

### Success
Used for positive/confirmation actions.

```blade
<x-pegboard::button variant="success">Approve</x-pegboard::button>
```

### Destructive
Used for dangerous/destructive actions.

```blade
<x-pegboard::button variant="destructive">Delete</x-pegboard::button>
```

### Outline
Subtle button with border, minimal background.

```blade
<x-pegboard::button variant="outline">Learn More</x-pegboard::button>
```

### Ghost
Minimal button with no background or border.

```blade
<x-pegboard::button variant="ghost">View Details</x-pegboard::button>
```

---

## Sizes

```blade
<x-pegboard::button size="xs">Extra Small</x-pegboard::button>
<x-pegboard::button size="sm">Small</x-pegboard::button>
<x-pegboard::button size="md">Medium</x-pegboard::button>
<x-pegboard::button size="lg">Large</x-pegboard::button>
```

---

## Icons

### Icon on the Left

```blade
<x-pegboard::button icon="arrow-left">Back</x-pegboard::button>
<x-pegboard::button icon="check" variant="success">Save</x-pegboard::button>
```

### Icon on the Right

```blade
<x-pegboard::button iconRight="arrow-right">Next</x-pegboard::button>
<x-pegboard::button iconRight="external-link">Open</x-pegboard::button>
```

### Icon-Only Buttons

For icon-only buttons, use the `iconOnly` prop for proper sizing:

```blade
<x-pegboard::button icon="trash" iconOnly variant="destructive">
    <span class="sr-only">Delete</span>
</x-pegboard::button>

<x-pegboard::button icon="pencil" iconOnly variant="outline">
    <span class="sr-only">Edit</span>
</x-pegboard::button>
```

**Important:** Always include screen-reader text (`sr-only`) for icon-only buttons to maintain accessibility.

---

## Loading States

### Default Loading Text

```blade
<x-pegboard::button loading>Loading...</x-pegboard::button>
```

### Custom Loading Text

```blade
<x-pegboard::button loading loadingText="Saving...">Save</x-pegboard::button>
<x-pegboard::button loading loadingText="Deleting..." variant="destructive">Delete</x-pegboard::button>
<x-pegboard::button loading loadingText="Processing..." variant="outline">Process</x-pegboard::button>
```

### Icon-Only Loading

Icon-only buttons hide the loading text and only show the spinner:

```blade
<x-pegboard::button loading iconOnly icon="trash">
    <span class="sr-only">Delete</span>
</x-pegboard::button>
```

---

## Disabled State

```blade
<x-pegboard::button disabled>Cannot Click</x-pegboard::button>
<x-pegboard::button disabled variant="destructive">Disabled</x-pegboard::button>
```

---

## Button Groups

Create seamless button groups using the `data-slot="button-group"` wrapper:

```blade
<div class="inline-flex rounded-lg border border-border" data-slot="button-group">
    <x-pegboard::button variant="ghost">Left</x-pegboard::button>
    <x-pegboard::button variant="ghost">Center</x-pegboard::button>
    <x-pegboard::button variant="ghost">Right</x-pegboard::button>
</div>
```

**Toolbar Example:**

```blade
<div class="inline-flex rounded-lg border border-border" data-slot="button-group">
    <x-pegboard::button icon="bold" iconOnly variant="ghost" size="sm">
        <span class="sr-only">Bold</span>
    </x-pegboard::button>
    <x-pegboard::button icon="italic" iconOnly variant="ghost" size="sm">
        <span class="sr-only">Italic</span>
    </x-pegboard::button>
    <x-pegboard::button icon="underline" iconOnly variant="ghost" size="sm">
        <span class="sr-only">Underline</span>
    </x-pegboard::button>
</div>
```

---

## Livewire Integration

The button component works seamlessly with Livewire:

```blade
{{-- Wire:click --}}
<x-pegboard::button wire:click="save">Save Changes</x-pegboard::button>

{{-- Wire:loading --}}
<x-pegboard::button wire:click="process" wire:loading.attr="disabled">
    <span wire:loading.remove>Process</span>
    <span wire:loading>Processing...</span>
</x-pegboard::button>

{{-- Better: Use loading prop --}}
<x-pegboard::button
    wire:click="save"
    :loading="$isSaving"
    loadingText="Saving..."
>
    Save
</x-pegboard::button>
```

---

## Real-World Examples

### Form Actions

```blade
<div class="flex gap-2">
    <x-pegboard::button variant="outline">Cancel</x-pegboard::button>
    <x-pegboard::button icon="check">Save Changes</x-pegboard::button>
</div>
```

### Hero Call-to-Action

```blade
<div class="flex gap-3">
    <x-pegboard::button size="lg" iconRight="arrow-right">Get Started</x-pegboard::button>
    <x-pegboard::button size="lg" variant="outline">Learn More</x-pegboard::button>
</div>
```

### Confirmation Dialog

```blade
<div class="flex justify-end gap-2">
    <x-pegboard::button variant="ghost" wire:click="$set('showModal', false)">
        Cancel
    </x-pegboard::button>
    <x-pegboard::button
        variant="destructive"
        icon="trash"
        wire:click="deleteAccount"
        :loading="$deleting"
        loadingText="Deleting..."
    >
        Delete Account
    </x-pegboard::button>
</div>
```

### Table Row Actions

```blade
<div class="flex gap-1">
    <x-pegboard::button icon="eye" iconOnly variant="ghost" size="xs">
        <span class="sr-only">View</span>
    </x-pegboard::button>
    <x-pegboard::button icon="pencil" iconOnly variant="ghost" size="xs">
        <span class="sr-only">Edit</span>
    </x-pegboard::button>
    <x-pegboard::button icon="trash" iconOnly variant="ghost" size="xs">
        <span class="sr-only">Delete</span>
    </x-pegboard::button>
</div>
```

---

## TypeScript Definitions

The Button component includes full TypeScript definitions:

```typescript
export type ButtonVariant = 'primary' | 'secondary' | 'destructive' | 'success' | 'outline' | 'ghost';
export type ButtonSize = 'xs' | 'sm' | 'md' | 'lg';

export interface ButtonProps {
    variant?: ButtonVariant;
    size?: ButtonSize;
    icon?: string;
    iconRight?: string;
    iconVariant?: string;
    loading?: boolean;
    disabled?: boolean;
    loadingText?: string;
    iconOnly?: boolean;
}
```

---

## Accessibility

The Button component follows accessibility best practices:

- **Semantic HTML:** Uses native `<button>` element
- **ARIA Attributes:** Includes `aria-busy="true"` during loading states
- **Disabled State:** Properly sets the `disabled` attribute
- **Screen Reader Support:** Encourages `sr-only` text for icon-only buttons
- **Keyboard Navigation:** Full keyboard support via native button behavior
- **Focus Indicators:** Visible focus ring using `focus-visible:ring-2`

---

## Styling & Theming

The Button component uses semantic design tokens from Tailwind v4's `@theme` block:

```css
/* Duration tokens */
duration-fast (150ms)
duration-normal (200ms)

/* Color tokens (auto light/dark) */
bg-primary, text-primary-foreground
bg-secondary, text-secondary-foreground
bg-destructive, text-destructive-foreground
bg-success (custom variant)
border-border
```

### Custom Styling

You can add custom classes via the standard `class` attribute:

```blade
<x-pegboard::button class="w-full">Full Width</x-pegboard::button>
<x-pegboard::button class="shadow-lg">Custom Shadow</x-pegboard::button>
```

---

## Component Files

- **PHP Class:** `packages/stratos/pegboard/src/View/Components/Button.php`
- **Blade Template:** `packages/stratos/pegboard/resources/views/components/button.blade.php`
- **TypeScript Types:** `packages/stratos/pegboard/resources/js/types/components.ts`

---

## Notes

- The component automatically detects icon-only mode based on slot content, but you can explicitly set `iconOnly="true"` for clarity
- Loading and disabled states are mutually exclusive but can be combined (both disable the button)
- Icon variants are auto-selected based on size (xs=micro, default=mini) but can be overridden
- Button groups automatically handle border radius and spacing when wrapped in `data-slot="button-group"`
- The component uses `active:scale-[0.98]` for a subtle press effect instead of `translate-y`
- All transitions use theme tokens for consistent timing across the design system