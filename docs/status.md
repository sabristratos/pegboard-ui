# Status Indicator Component

A simple status indicator component for displaying status with colored dots and optional labels, perfect for showing online/offline states, availability, or other status information.

## Features

- 5 semantic variants (success, warning, danger, info, default)
- 3 sizes (sm, md, lg)
- Optional pulse animation for live states
- Optional text label
- Data attribute-driven styling
- Custom class support

## Basic Usage

```blade
{{-- Simple status dot --}}
<x-pegboard::status variant="success" />

{{-- With label --}}
<x-pegboard::status variant="success" label="Online" />

{{-- With pulse animation --}}
<x-pegboard::status variant="danger" label="Live" :pulse="true" />

{{-- Different sizes --}}
<x-pegboard::status size="sm" variant="success" label="Small" />
<x-pegboard::status size="md" variant="warning" label="Medium" />
<x-pegboard::status size="lg" variant="danger" label="Large" />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Status color: `success`, `warning`, `danger`, `info`, `default` |
| `size` | string | `'md'` | Size: `sm`, `md`, `lg` |
| `pulse` | bool | `false` | Enable pulse animation |
| `label` | string\|null | `null` | Optional text label |

## Variants

### Success
Green indicator for positive states:
```blade
<x-pegboard::status variant="success" label="Online" />
<x-pegboard::status variant="success" label="Available" />
<x-pegboard::status variant="success" label="Active" />
```

### Warning
Yellow/orange indicator for warnings:
```blade
<x-pegboard::status variant="warning" label="Away" />
<x-pegboard::status variant="warning" label="Idle" />
<x-pegboard::status variant="warning" label="Pending" />
```

### Danger
Red indicator for errors or critical states:
```blade
<x-pegboard::status variant="danger" label="Offline" />
<x-pegboard::status variant="danger" label="Error" />
<x-pegboard::status variant="danger" label="Busy" />
```

### Info
Blue indicator for informational states:
```blade
<x-pegboard::status variant="info" label="In Progress" />
<x-pegboard::status variant="info" label="Syncing" />
```

### Default
Gray indicator for neutral or unknown states:
```blade
<x-pegboard::status variant="default" label="Unknown" />
<x-pegboard::status variant="default" label="Inactive" />
```

## Sizes

```blade
<x-pegboard::status size="sm" variant="success" label="Small status" />
<x-pegboard::status size="md" variant="success" label="Medium status" />
<x-pegboard::status size="lg" variant="success" label="Large status" />
```

## Pulse Animation

Add attention-grabbing pulse animation for live or active states:

```blade
<x-pegboard::status variant="success" label="Live Recording" :pulse="true" />
<x-pegboard::status variant="danger" label="Alert" :pulse="true" />
<x-pegboard::status variant="info" label="Broadcasting" :pulse="true" />
```

## Data Attribute Architecture

The Status component uses data attributes for CSS-driven styling:

```blade
<span
    data-variant="success"
    data-size="md"
    class="
        inline-block rounded-full
        data-[size=sm]:h-2 data-[size=sm]:w-2
        data-[size=md]:h-3 data-[size=md]:w-3
        data-[size=lg]:h-4 data-[size=lg]:w-4
        data-[variant=success]:bg-success
        data-[variant=warning]:bg-warning
        data-[variant=danger]:bg-destructive
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
{{-- Custom spacing --}}
<x-pegboard::status variant="success" label="Online" class="gap-3" />

{{-- Custom label styling --}}
<x-pegboard::status variant="success" label="Online" class="text-sm font-semibold" />

{{-- Custom dot size (overrides size prop) --}}
<x-pegboard::status variant="danger" label="Critical" class="[&>span]:h-5 [&>span]:w-5" />
```

## Common Patterns

### User Status List
```blade
<div class="space-y-3">
    <div class="flex items-center gap-3">
        <img src="/avatar-1.jpg" class="h-8 w-8 rounded-full" />
        <span class="font-medium">John Doe</span>
        <x-pegboard::status variant="success" label="Online" size="sm" />
    </div>

    <div class="flex items-center gap-3">
        <img src="/avatar-2.jpg" class="h-8 w-8 rounded-full" />
        <span class="font-medium">Jane Smith</span>
        <x-pegboard::status variant="warning" label="Away" size="sm" />
    </div>

    <div class="flex items-center gap-3">
        <img src="/avatar-3.jpg" class="h-8 w-8 rounded-full" />
        <span class="font-medium">Bob Johnson</span>
        <x-pegboard::status variant="default" label="Offline" size="sm" />
    </div>
</div>
```

### Server Status Dashboard
```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-pegboard::card padding="md">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold">API Server</h3>
                <p class="text-sm text-muted-foreground">api.example.com</p>
            </div>
            <x-pegboard::status variant="success" :pulse="true" />
        </div>
    </x-pegboard::card>

    <x-pegboard::card padding="md">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold">Database</h3>
                <p class="text-sm text-muted-foreground">db.example.com</p>
            </div>
            <x-pegboard::status variant="success" :pulse="true" />
        </div>
    </x-pegboard::card>

    <x-pegboard::card padding="md">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold">Cache Server</h3>
                <p class="text-sm text-muted-foreground">cache.example.com</p>
            </div>
            <x-pegboard::status variant="danger" />
        </div>
    </x-pegboard::card>
</div>
```

### Inline Status
```blade
<p>
    The deployment is
    <x-pegboard::status variant="success" label="completed" size="sm" class="inline-flex" />
    and all services are running normally.
</p>
```

## Accessibility

- Uses semantic HTML
- Text labels provide context for screen readers
- Proper color contrast ratios
- Works without JavaScript
- Pulse animation respects `prefers-reduced-motion`
