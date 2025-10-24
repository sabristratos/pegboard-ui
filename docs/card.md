# Card Component

A versatile card container with different elevation levels and padding options, perfect for grouping related content.

## Features

- 3 visual variants with different shadow levels
- 4 padding sizes (none, sm, md, lg)
- Data attribute-driven styling
- Custom class support
- Consistent border and background styling

## Basic Usage

```blade
{{-- Simple card --}}
<x-pegboard::card>
    <h3>Card Title</h3>
    <p>Card content goes here.</p>
</x-pegboard::card>

{{-- With variant --}}
<x-pegboard::card variant="elevated">
    <h3>Elevated Card</h3>
    <p>Higher shadow for emphasis.</p>
</x-pegboard::card>

{{-- With custom padding --}}
<x-pegboard::card padding="lg">
    <h3>Large Padding</h3>
    <p>More breathing room inside.</p>
</x-pegboard::card>

{{-- No padding (useful for images) --}}
<x-pegboard::card padding="none">
    <img src="/image.jpg" class="w-full rounded-t-lg" />
    <div class="p-4">
        <h3>Image Card</h3>
        <p>Custom padding inside wrapper div.</p>
    </div>
</x-pegboard::card>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Visual variant: `default`, `elevated`, `outline` |
| `padding` | string | `'md'` | Padding size: `none`, `sm`, `md`, `lg` |

## Variants

### Default
Standard shadow level for most use cases:
```blade
<x-pegboard::card variant="default">
    <h3>Default Card</h3>
    <p>Standard shadow style.</p>
</x-pegboard::card>
```

### Elevated
Larger shadow for emphasis or hover states:
```blade
<x-pegboard::card variant="elevated">
    <h3>Elevated Card</h3>
    <p>Larger shadow for prominence.</p>
</x-pegboard::card>
```

### Outline
Subtle shadow for minimal designs:
```blade
<x-pegboard::card variant="outline">
    <h3>Outline Card</h3>
    <p>Minimal shadow style.</p>
</x-pegboard::card>
```

## Padding Options

### None
No padding (useful for full-bleed images or custom layouts):
```blade
<x-pegboard::card padding="none">
    <div class="aspect-video bg-gradient-to-br from-primary to-secondary"></div>
    <div class="p-6">
        <h3>Full-width Header</h3>
    </div>
</x-pegboard::card>
```

### Small
Compact spacing:
```blade
<x-pegboard::card padding="sm">
    <p class="text-sm">Compact card with small padding.</p>
</x-pegboard::card>
```

### Medium (Default)
Balanced spacing for most use cases:
```blade
<x-pegboard::card padding="md">
    <h3>Standard Card</h3>
    <p>Medium padding is the default.</p>
</x-pegboard::card>
```

### Large
Generous spacing for important content:
```blade
<x-pegboard::card padding="lg">
    <h2>Featured Content</h2>
    <p>Large padding provides breathing room.</p>
</x-pegboard::card>
```

## Data Attribute Architecture

The Card component uses data attributes for CSS-driven styling:

```blade
<div
    data-variant="elevated"
    data-padding="md"
    class="
        rounded-lg border bg-card
        data-[variant=elevated]:shadow-lg
        data-[variant=outline]:shadow-sm
        data-[variant=default]:shadow-sm
        data-[padding=none]:p-0
        data-[padding=sm]:p-3
        data-[padding=md]:p-4
        data-[padding=lg]:p-6
    "
>
```

**Benefits:**
- CSS handles styling (no PHP match statements)
- Custom classes merge cleanly
- Consistent with Pegboard architecture
- Better performance

## Customization

Pass custom classes that merge with base styles:

```blade
{{-- Override border color --}}
<x-pegboard::card class="border-primary">
    <h3>Custom Border</h3>
</x-pegboard::card>

{{-- Add hover effect --}}
<x-pegboard::card class="hover:shadow-xl transition-shadow cursor-pointer">
    <h3>Interactive Card</h3>
    <p>Hover to see effect.</p>
</x-pegboard::card>

{{-- Custom background --}}
<x-pegboard::card class="bg-gradient-to-br from-primary/10 to-secondary/10">
    <h3>Gradient Background</h3>
</x-pegboard::card>
```

## Common Patterns

### Card Grid
```blade
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <x-pegboard::card variant="default" padding="md">
        <h3 class="font-semibold mb-2">Feature 1</h3>
        <p class="text-sm text-muted-foreground">Description</p>
    </x-pegboard::card>

    <x-pegboard::card variant="default" padding="md">
        <h3 class="font-semibold mb-2">Feature 2</h3>
        <p class="text-sm text-muted-foreground">Description</p>
    </x-pegboard::card>

    <x-pegboard::card variant="default" padding="md">
        <h3 class="font-semibold mb-2">Feature 3</h3>
        <p class="text-sm text-muted-foreground">Description</p>
    </x-pegboard::card>
</div>
```

### Card with Header and Footer
```blade
<x-pegboard::card padding="none">
    <div class="border-b border-border p-4">
        <h3 class="font-semibold">Card Header</h3>
    </div>

    <div class="p-4">
        <p>Main content goes here.</p>
    </div>

    <div class="border-t border-border p-4 bg-muted/30">
        <button class="text-sm text-primary">Action</button>
    </div>
</x-pegboard::card>
```

## Accessibility

- Uses semantic HTML
- Proper color contrast ratios
- Works without JavaScript
- Respects user motion preferences (via `transition-all`)
