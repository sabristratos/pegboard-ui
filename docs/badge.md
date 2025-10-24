# Badge Component

A versatile badge component for labels, indicators, and status displays with multiple variants, colors, and configurations.

## Features

- 4 visual variants (solid, flat, faded, shadow)
- 6 semantic colors (default, primary, secondary, success, warning, danger)
- 3 sizes (sm, md, lg)
- Icon support (left and/or right)
- Dot badge mode for minimal indicators
- Wrapper mode for positioning badges on other elements
- Custom class support with sensible defaults

## Basic Usage

```blade
{{-- Simple badge --}}
<x-pegboard::badge>Default</x-pegboard::badge>

{{-- With variant and color --}}
<x-pegboard::badge variant="solid" color="primary">Primary</x-pegboard::badge>
<x-pegboard::badge variant="flat" color="success">Success</x-pegboard::badge>

{{-- Different sizes --}}
<x-pegboard::badge size="sm">Small</x-pegboard::badge>
<x-pegboard::badge size="md">Medium</x-pegboard::badge>
<x-pegboard::badge size="lg">Large</x-pegboard::badge>

{{-- With icons --}}
<x-pegboard::badge icon="check" color="success">Verified</x-pegboard::badge>
<x-pegboard::badge icon-right="arrow-right" color="primary">Next</x-pegboard::badge>

{{-- Dot badge --}}
<x-pegboard::badge :is-dot="true" color="danger" />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'solid'` | Visual variant: `solid`, `flat`, `faded`, `shadow` |
| `color` | string | `'default'` | Color theme: `default`, `primary`, `secondary`, `success`, `warning`, `danger` |
| `size` | string | `'md'` | Size: `sm`, `md`, `lg` |
| `shape` | string | `'default'` | Shape: `default` (rounded), `circle` (fully rounded) |
| `icon` | string\|null | `null` | Icon name for left side |
| `iconRight` | string\|null | `null` | Icon name for right side |
| `isDot` | bool | `false` | Display as a minimal dot indicator |
| `showOutline` | bool | `false` | Add ring outline (useful for overlaying on images) |
| `isInvisible` | bool | `false` | Hide badge while maintaining layout space |
| `placement` | string | `'top-right'` | Position when used in wrapper mode: `top-right`, `top-left`, `bottom-right`, `bottom-left` |
| `content` | string | `''` | Badge content when used in wrapper mode |

## Variants

### Solid
Full background color with contrasting text:
```blade
<x-pegboard::badge variant="solid" color="primary">Solid</x-pegboard::badge>
```

### Flat
Subtle background with color-matched text:
```blade
<x-pegboard::badge variant="flat" color="success">Flat</x-pegboard::badge>
```

### Faded
Minimal background with border:
```blade
<x-pegboard::badge variant="faded" color="warning">Faded</x-pegboard::badge>
```

### Shadow
Solid variant with drop shadow (customizable via class attribute):
```blade
<x-pegboard::badge variant="shadow" color="danger">Shadow</x-pegboard::badge>
<x-pegboard::badge variant="shadow" color="primary" class="shadow-xl">Custom Shadow</x-pegboard::badge>
```

## Wrapper Mode

Position badges on other elements (like notification counts):

```blade
<x-pegboard::badge content="5" color="danger" placement="top-right">
    <button>
        <x-pegboard::icon name="bell" class="h-6 w-6" />
    </button>
</x-pegboard::badge>

<x-pegboard::badge :is-dot="true" color="success" placement="bottom-right">
    <img src="/avatar.jpg" class="h-10 w-10 rounded-full" />
</x-pegboard::badge>
```

## Icon Badges

### With Left Icon
```blade
<x-pegboard::badge icon="star" color="warning">Featured</x-pegboard::badge>
```

### With Right Icon
```blade
<x-pegboard::badge icon-right="chevron-down" color="primary">Dropdown</x-pegboard::badge>
```

### Icon Only
```blade
<x-pegboard::badge icon="check" color="success" shape="circle" />
```

## Dot Badges

Minimal status indicators:
```blade
<x-pegboard::badge :is-dot="true" color="success" />
<x-pegboard::badge :is-dot="true" color="warning" />
<x-pegboard::badge :is-dot="true" color="danger" />
```

## Customization

Pass custom classes that merge with base styles:

```blade
{{-- Override shadow --}}
<x-pegboard::badge variant="shadow" color="primary" class="shadow-2xl">
    Custom shadow size
</x-pegboard::badge>

{{-- Add spacing --}}
<x-pegboard::badge color="success" class="mx-2 my-4">
    Custom spacing
</x-pegboard::badge>

{{-- Custom font weight --}}
<x-pegboard::badge color="primary" class="font-bold">
    Bold text
</x-pegboard::badge>
```

## Accessibility

- Uses semantic HTML
- Icons are decorative (text provides full context)
- Proper color contrast ratios
- Works without JavaScript
- Maintains layout space when `isInvisible` is true
