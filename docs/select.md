# Select Component

A powerful select component with single/multi-select support, search functionality, icon support, and two visual variants.

## Features

- Single and multi-select modes
- Optional search/filter functionality
- 2 visual variants (default, pillbox for multi-select)
- Icon support for options
- Keyboard navigation (arrow keys, enter, escape)
- Loading state with spinner
- Hidden inputs for traditional form submission
- Alpine.js-powered with native Popover API
- Smooth animations using native CSS @starting-style
- Data attribute-driven styling

## Basic Usage

```blade
{{-- Simple select --}}
<x-pegboard::select placeholder="Choose an option">
    <x-pegboard::option value="1">Option 1</x-pegboard::option>
    <x-pegboard::option value="2">Option 2</x-pegboard::option>
    <x-pegboard::option value="3">Option 3</x-pegboard::option>
</x-pegboard::select>

{{-- With name for form submission --}}
<x-pegboard::select name="country" placeholder="Select country">
    <x-pegboard::option value="us">United States</x-pegboard::option>
    <x-pegboard::option value="ca">Canada</x-pegboard::option>
    <x-pegboard::option value="uk">United Kingdom</x-pegboard::option>
</x-pegboard::select>

{{-- Pre-selected value --}}
<x-pegboard::select name="priority" :value="'high'">
    <x-pegboard::option value="low">Low</x-pegboard::option>
    <x-pegboard::option value="medium">Medium</x-pegboard::option>
    <x-pegboard::option value="high">High</x-pegboard::option>
</x-pegboard::select>

{{-- With Livewire wire:model --}}
<x-pegboard::select wire:model.live="selectedCategory">
    <x-pegboard::option value="tech">Technology</x-pegboard::option>
    <x-pegboard::option value="design">Design</x-pegboard::option>
    <x-pegboard::option value="marketing">Marketing</x-pegboard::option>
</x-pegboard::select>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `multiple` | bool | `false` | Enable multi-select mode |
| `searchable` | bool | `false` | Show search input for filtering options |
| `placeholder` | string | `'Select...'` | Placeholder text when no selection |
| `variant` | string | `'default'` | Visual variant: `default`, `pillbox` (pillbox only works with multiple) |
| `size` | string | `'md'` | Size: `sm`, `md` |
| `name` | string\|null | `null` | Form input name (required for form submission) |
| `value` | mixed | `null` | Pre-selected value(s) |
| `loading` | bool | `false` | Show loading spinner and disable select |

## Single Select

Basic single-select dropdown:

```blade
<x-pegboard::select name="status" placeholder="Select status">
    <x-pegboard::option value="active">Active</x-pegboard::option>
    <x-pegboard::option value="pending">Pending</x-pegboard::option>
    <x-pegboard::option value="inactive">Inactive</x-pegboard::option>
</x-pegboard::select>
```

**Single Select Features:**
- Shows selected option text in trigger button
- Shows option icon if provided (see Icon Support section)
- Updates hidden input value for form submission
- Closes dropdown after selection

## Multi-Select

Select multiple options:

```blade
<x-pegboard::select
    :multiple="true"
    name="tags"
    placeholder="Select tags"
>
    <x-pegboard::option value="laravel">Laravel</x-pegboard::option>
    <x-pegboard::option value="vue">Vue.js</x-pegboard::option>
    <x-pegboard::option value="tailwind">Tailwind CSS</x-pegboard::option>
    <x-pegboard::option value="alpine">Alpine.js</x-pegboard::option>
</x-pegboard::select>
```

**Multi-Select Features:**
- Shows "X selected" count in trigger button
- Checkbox next to each option
- Click option to toggle selection
- Dropdown stays open for multiple selections
- Generates array of hidden inputs (e.g., `name="tags[]"`)

## Variants

### Default Variant

Standard dropdown style showing count for multi-select:

```blade
<x-pegboard::select
    variant="default"
    :multiple="true"
    placeholder="Choose options"
>
    <x-pegboard::option value="1">Option 1</x-pegboard::option>
    <x-pegboard::option value="2">Option 2</x-pegboard::option>
</x-pegboard::select>
```

### Pillbox Variant

Shows selected items as removable pills (only works with `multiple`):

```blade
<x-pegboard::select
    variant="pillbox"
    :multiple="true"
    placeholder="Choose tags"
>
    <x-pegboard::option value="php">PHP</x-pegboard::option>
    <x-pegboard::option value="js">JavaScript</x-pegboard::option>
    <x-pegboard::option value="css">CSS</x-pegboard::option>
</x-pegboard::select>
```

**Pillbox Features:**
- Selected options displayed as pills in the trigger button
- Each pill has an X button to remove that specific option
- Pills wrap to multiple lines if needed
- Better UX when many options are selected

## Searchable Select

Add search/filter functionality:

```blade
<x-pegboard::select
    :searchable="true"
    placeholder="Search countries"
>
    <x-pegboard::option value="us">United States</x-pegboard::option>
    <x-pegboard::option value="ca">Canada</x-pegboard::option>
    <x-pegboard::option value="uk">United Kingdom</x-pegboard::option>
    <x-pegboard::option value="au">Australia</x-pegboard::option>
    <x-pegboard::option value="de">Germany</x-pegboard::option>
    {{-- ... more options --}}
</x-pegboard::select>
```

**Search Features:**
- Search input appears at top of dropdown
- Filters options in real-time as you type
- Shows "No results found" if no matches
- Press Escape to close dropdown
- Press Enter to select active option
- Arrow keys navigate filtered results

## Icon Support

Options can display icons using the `icon` attribute:

```blade
<x-pegboard::select placeholder="Select payment method">
    <x-pegboard::option value="card" icon="credit-card">
        Credit Card
    </x-pegboard::option>
    <x-pegboard::option value="paypal" icon="globe-alt">
        PayPal
    </x-pegboard::option>
    <x-pegboard::option value="bank" icon="building-library">
        Bank Transfer
    </x-pegboard::option>
</x-pegboard::select>
```

**Icon Features:**
- Icons appear on the left of option text
- Selected option shows icon in trigger button (single select only)
- Icons in options are smaller (w-4 h-4)
- Uses Pegboard Icon component

## Loading State

Show loading spinner and disable select:

```blade
{{-- PHP-driven loading state --}}
<x-pegboard::select :loading="true" placeholder="Loading...">
    <x-pegboard::option value="1">Option 1</x-pegboard::option>
</x-pegboard::select>

{{-- With Livewire wire:loading --}}
<x-pegboard::select
    wire:model="category"
    wire:loading.delay.attr="loading"
    wire:target="category"
    placeholder="Select category"
>
    <x-pegboard::option value="tech">Technology</x-pegboard::option>
    <x-pegboard::option value="design">Design</x-pegboard::option>
</x-pegboard::select>
```

**Loading State Features:**
- Replaces chevron icon with spinner
- Automatically disables trigger button
- Adds `aria-busy="true"` for accessibility
- Prevents dropdown from opening

## Keyboard Navigation

**When dropdown is closed:**
- Click trigger button or press Space/Enter to open

**When dropdown is open:**
- **Arrow Down** - Navigate to next option
- **Arrow Up** - Navigate to previous option
- **Enter** - Select active option
- **Escape** - Close dropdown
- **Click outside** - Close dropdown

**With search enabled:**
- All keyboard shortcuts work within search input
- Type to filter options
- Arrow keys navigate filtered results

## Form Submission

The select component generates hidden inputs for traditional form submission:

**Single select:**
```html
<!-- Generates -->
<input type="hidden" name="category" value="tech" />
```

**Multi-select:**
```html
<!-- Generates -->
<input type="hidden" name="tags[]" value="laravel" />
<input type="hidden" name="tags[]" value="vue" />
<input type="hidden" name="tags[]" value="tailwind" />
```

**Usage:**
```blade
<form method="POST" action="/save">
    @csrf
    <x-pegboard::select name="status" :value="$user->status">
        <x-pegboard::option value="active">Active</x-pegboard::option>
        <x-pegboard::option value="inactive">Inactive</x-pegboard::option>
    </x-pegboard::select>

    <button type="submit">Save</button>
</form>
```

## Livewire Integration

Works seamlessly with Livewire wire:model:

```blade
{{-- Single select --}}
<x-pegboard::select wire:model.live="selectedStatus">
    <x-pegboard::option value="active">Active</x-pegboard::option>
    <x-pegboard::option value="inactive">Inactive</x-pegboard::option>
</x-pegboard::select>

{{-- Multi-select --}}
<x-pegboard::select :multiple="true" wire:model="selectedTags">
    <x-pegboard::option value="laravel">Laravel</x-pegboard::option>
    <x-pegboard::option value="vue">Vue.js</x-pegboard::option>
    <x-pegboard::option value="tailwind">Tailwind CSS</x-pegboard::option>
</x-pegboard::select>
```

**How it works:**
- Component uses Alpine.js `x-modelable` directive
- Single select: `x-modelable="selectedValue"`
- Multi-select: `x-modelable="selectedValues"`
- Automatically syncs with Livewire properties

## Native Popover API

The dropdown uses the native Popover API with custom animations:

```blade
<!-- Popover element -->
<div
    x-anchor.bottom-start.offset.8="$refs.trigger"
    popover="manual"
    class="transition-[opacity,transform,overlay,display] duration-fast ease-out transition-discrete starting:opacity-0 starting:scale-95"
>
```

**Benefits:**
- Browser handles positioning and z-index management
- Smooth enter/exit animations using native CSS
- No JavaScript animation libraries needed
- Accessible by default (focus management, escape key)

## Sizing System

Select sizing uses PHP match expressions:

```php
// Button/trigger sizing
$sizeClasses = match($size) {
    'sm' => 'px-2 py-1 text-sm min-h-8',
    default => 'px-3 py-1.5 text-base min-h-[38px]',
};
```

## Customization

Pass custom classes that merge with base styles:

```blade
{{-- Custom width --}}
<x-pegboard::select class="w-full max-w-md">
    <x-pegboard::option value="1">Option 1</x-pegboard::option>
</x-pegboard::select>

{{-- Custom styling --}}
<x-pegboard::select class="!border-2 !border-primary">
    <x-pegboard::option value="1">Option 1</x-pegboard::option>
</x-pegboard::select>
```

## Accessibility

- Uses `role="combobox"` and `role="listbox"` for screen readers
- Proper `aria-expanded`, `aria-controls`, `aria-activedescendant` attributes
- Multi-select has `aria-multiselectable="true"`
- Loading state adds `disabled` and `aria-busy="true"` attributes
- Keyboard navigation follows ARIA Combobox pattern
- Focus visible ring for keyboard navigation
- Search input has proper placeholder and focus management
